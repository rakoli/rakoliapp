<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FloatExchangeRequest;
use App\Models\FloatExchange;
use App\Models\Network;
use App\Models\Shift;
use App\Utils\ErrorCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FloatExchangeAPI extends Controller
{
    /**
     * Display a listing of float exchanges.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = FloatExchange::query();

            // Remove location scope temporarily if user has no locations
            $user = auth()->user();
            if ($user->type == 'agent' && (!$user->locations || $user->locations->isEmpty())) {
                $query = FloatExchange::withoutGlobalScope('App\Models\Scopes\LocationScoped');
            }

            $query->with([
                'fromNetwork.agency',
                'toNetwork.agency',
                'fromFsp',
                'toFsp',
                'shift',
                'user'
            ])->where('business_code', $user->business_code);

            // Filter by shift if provided
            if ($request->filled('shift_id')) {
                $query->where('shift_id', $request->shift_id);
            }

            // Filter by status if provided
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filter by date range
            if ($request->filled('from_date')) {
                $query->whereDate('created_at', '>=', $request->from_date);
            }

            if ($request->filled('to_date')) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            $floatExchanges = $query->orderBy('created_at', 'desc')->paginate(20);

            return response()->json([
                'success' => true,
                'data' => $floatExchanges->map(function ($exchange) {
                    return [
                        'id' => $exchange->id,
                        'code' => $exchange->code,
                        'from_network' => [
                            'code' => $exchange->fromNetwork->code,
                            'name' => $exchange->fromNetwork->name,
                        ],
                        'from_fsp' => [
                            'code' => $exchange->fromFsp->code,
                            'name' => $exchange->fromFsp->name,
                            'logo' => $exchange->fromFsp->logo,
                        ],
                        'to_network' => [
                            'code' => $exchange->toNetwork->code,
                            'name' => $exchange->toNetwork->name,
                        ],
                        'to_fsp' => [
                            'code' => $exchange->toFsp->code,
                            'name' => $exchange->toFsp->name,
                            'logo' => $exchange->toFsp->logo,
                        ],
                        'amount' => $exchange->amount,
                        'fee' => $exchange->fee,
                        'total_amount' => $exchange->total_amount,
                        'currency' => $exchange->currency,
                        'from_balance_before' => $exchange->from_balance_before,
                        'from_balance_after' => $exchange->from_balance_after,
                        'to_balance_before' => $exchange->to_balance_before,
                        'to_balance_after' => $exchange->to_balance_after,
                        'status' => $exchange->status,
                        'notes' => $exchange->notes,
                        'shift_id' => $exchange->shift_id,
                        'user' => [
                            'code' => $exchange->user->code,
                            'name' => $exchange->user->name(),
                        ],
                        'created_at' => $exchange->created_at,
                        'updated_at' => $exchange->updated_at,
                    ];
                }),
                'pagination' => [
                    'total' => $floatExchanges->total(),
                    'per_page' => $floatExchanges->perPage(),
                    'current_page' => $floatExchanges->currentPage(),
                    'last_page' => $floatExchanges->lastPage(),
                ],
                'message' => 'Float exchanges retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('FloatExchangeAPI::index - Error: ' . $e->getMessage());
            Log::error('FloatExchangeAPI::index - Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve float exchanges: ' . $e->getMessage(),
                'code' => ErrorCode::RETRIEVE_FAILED
            ], 500);
        }
    }

    /**
     * Store a newly created float exchange (transfer balance from one FSP to another).
     */
    public function store(FloatExchangeRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            Log::info('FloatExchangeAPI::store - Request data: ' . json_encode($request->validated()));

            $user = auth()->user();
            $data = $request->validated();

            // Get the networks
            $fromNetwork = Network::where('code', $data['from_network_code'])
                ->where('business_code', $user->business_code)
                ->with('agency')
                ->first();

            $toNetwork = Network::where('code', $data['to_network_code'])
                ->where('business_code', $user->business_code)
                ->with('agency')
                ->first();

            if (!$fromNetwork || !$toNetwork) {
                return response()->json([
                    'success' => false,
                    'message' => 'One or both networks not found',
                    'code' => ErrorCode::NOT_FOUND
                ], 404);
            }

            // Validate both networks are finance type
            if ($fromNetwork->type !== 'Finance' || $toNetwork->type !== 'Finance') {
                return response()->json([
                    'success' => false,
                    'message' => 'Both networks must be finance type',
                    'code' => ErrorCode::VALIDATION_FAILED
                ], 422);
            }

            // Check if source network has sufficient balance
            $amount = $data['amount'];
            $fee = round($amount * 0.001, 2); // 0.1% fee
            $totalAmount = $amount + $fee;

            if ($fromNetwork->balance < $totalAmount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient balance in source network',
                    'data' => [
                        'available' => $fromNetwork->balance,
                        'required' => $totalAmount,
                        'amount' => $amount,
                        'fee' => $fee
                    ],
                    'code' => ErrorCode::VALIDATION_FAILED
                ], 422);
            }

            // Get active shift
            $shiftQuery = Shift::where('user_code', $user->code)
                ->where('business_code', $user->business_code)
                ->where('status', 'open');

            // Only filter by location if user has a location_code
            if ($user->location_code) {
                $shiftQuery->where('location_code', $user->location_code);
            }

            $shift = $shiftQuery->latest()->first();

            if (!$shift) {
                return response()->json([
                    'success' => false,
                    'message' => 'No open shift found. Please start a shift first.',
                    'code' => ErrorCode::VALIDATION_FAILED
                ], 422);
            }

            // Record balances before transaction
            $fromBalanceBefore = $fromNetwork->balance;
            $toBalanceBefore = $toNetwork->balance;

            // Update network balances
            $fromNetwork->balance -= $totalAmount;
            $fromNetwork->save();

            $toNetwork->balance += $amount; // Only the amount, not the fee
            $toNetwork->save();

            // Create float exchange record
            $floatExchange = FloatExchange::create([
                'code' => generateCode('FLX', $user->business_code),
                'user_code' => $user->code,
                'business_code' => $user->business_code,
                'location_code' => $shift->location_code, // Use shift's location_code
                'shift_id' => $shift->id,
                'from_network_code' => $fromNetwork->code,
                'from_fsp_code' => $fromNetwork->fsp_code,
                'to_network_code' => $toNetwork->code,
                'to_fsp_code' => $toNetwork->fsp_code,
                'amount' => $amount,
                'fee' => $fee,
                'total_amount' => $totalAmount,
                'currency' => $fromNetwork->balance_currency,
                'from_balance_before' => $fromBalanceBefore,
                'from_balance_after' => $fromNetwork->balance,
                'to_balance_before' => $toBalanceBefore,
                'to_balance_after' => $toNetwork->balance,
                'status' => 'completed',
                'notes' => $data['notes'] ?? null,
            ]);

            // Load relationships for response
            $floatExchange->load(['fromNetwork.agency', 'toNetwork.agency', 'fromFsp', 'toFsp', 'shift', 'user']);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $floatExchange->id,
                    'code' => $floatExchange->code,
                    'from_network' => [
                        'code' => $floatExchange->fromNetwork->code,
                        'name' => $floatExchange->fromNetwork->name,
                        'balance' => $floatExchange->from_balance_after,
                    ],
                    'from_fsp' => [
                        'code' => $floatExchange->fromFsp->code,
                        'name' => $floatExchange->fromFsp->name,
                        'logo' => $floatExchange->fromFsp->logo,
                    ],
                    'to_network' => [
                        'code' => $floatExchange->toNetwork->code,
                        'name' => $floatExchange->toNetwork->name,
                        'balance' => $floatExchange->to_balance_after,
                    ],
                    'to_fsp' => [
                        'code' => $floatExchange->toFsp->code,
                        'name' => $floatExchange->toFsp->name,
                        'logo' => $floatExchange->toFsp->logo,
                    ],
                    'amount' => $floatExchange->amount,
                    'fee' => $floatExchange->fee,
                    'total_amount' => $floatExchange->total_amount,
                    'currency' => $floatExchange->currency,
                    'status' => $floatExchange->status,
                    'notes' => $floatExchange->notes,
                    'shift_id' => $floatExchange->shift_id,
                    'created_at' => $floatExchange->created_at,
                    'updated_at' => $floatExchange->updated_at,
                ],
                'message' => 'Float exchange completed successfully'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('FloatExchangeAPI::store - Error: ' . $e->getMessage());
            Log::error('FloatExchangeAPI::store - Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create float exchange: ' . $e->getMessage(),
                'code' => ErrorCode::CREATE_FAILED
            ], 500);
        }
    }

    /**
     * Display the specified float exchange.
     */
    public function show(string $code): JsonResponse
    {
        try {
            $floatExchange = FloatExchange::with([
                'fromNetwork.agency',
                'toNetwork.agency',
                'fromFsp',
                'toFsp',
                'shift',
                'user'
            ])
                ->where('business_code', auth()->user()->business_code)
                ->where('code', $code)
                ->first();

            if (!$floatExchange) {
                return response()->json([
                    'success' => false,
                    'message' => 'Float exchange not found',
                    'code' => ErrorCode::NOT_FOUND
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $floatExchange->id,
                    'code' => $floatExchange->code,
                    'from_network' => [
                        'code' => $floatExchange->fromNetwork->code,
                        'name' => $floatExchange->fromNetwork->name,
                    ],
                    'from_fsp' => [
                        'code' => $floatExchange->fromFsp->code,
                        'name' => $floatExchange->fromFsp->name,
                        'logo' => $floatExchange->fromFsp->logo,
                    ],
                    'to_network' => [
                        'code' => $floatExchange->toNetwork->code,
                        'name' => $floatExchange->toNetwork->name,
                    ],
                    'to_fsp' => [
                        'code' => $floatExchange->toFsp->code,
                        'name' => $floatExchange->toFsp->name,
                        'logo' => $floatExchange->toFsp->logo,
                    ],
                    'amount' => $floatExchange->amount,
                    'fee' => $floatExchange->fee,
                    'total_amount' => $floatExchange->total_amount,
                    'currency' => $floatExchange->currency,
                    'from_balance_before' => $floatExchange->from_balance_before,
                    'from_balance_after' => $floatExchange->from_balance_after,
                    'to_balance_before' => $floatExchange->to_balance_before,
                    'to_balance_after' => $floatExchange->to_balance_after,
                    'status' => $floatExchange->status,
                    'notes' => $floatExchange->notes,
                    'shift_id' => $floatExchange->shift_id,
                    'user' => [
                        'code' => $floatExchange->user->code,
                        'name' => $floatExchange->user->name(),
                    ],
                    'created_at' => $floatExchange->created_at,
                    'updated_at' => $floatExchange->updated_at,
                ],
                'message' => 'Float exchange retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('FloatExchangeAPI::show - Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve float exchange',
                'code' => ErrorCode::RETRIEVE_FAILED
            ], 500);
        }
    }

    /**
     * Get float exchange statistics for the authenticated user/business.
     */
    public function statistics(Request $request): JsonResponse
    {
        try {
            $query = FloatExchange::where('business_code', auth()->user()->business_code);

            // Filter by date range if provided
            if ($request->filled('from_date')) {
                $query->whereDate('created_at', '>=', $request->from_date);
            }

            if ($request->filled('to_date')) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            $stats = [
                'total_exchanges' => $query->count(),
                'total_amount_exchanged' => $query->sum('amount'),
                'total_fees_collected' => $query->sum('fee'),
                'completed_exchanges' => $query->where('status', 'completed')->count(),
                'pending_exchanges' => $query->where('status', 'pending')->count(),
                'failed_exchanges' => $query->where('status', 'failed')->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Statistics retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('FloatExchangeAPI::statistics - Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve statistics',
                'code' => ErrorCode::RETRIEVE_FAILED
            ], 500);
        }
    }
}

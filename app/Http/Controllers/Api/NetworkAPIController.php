<?php

namespace App\Http\Controllers\Api;

use App\Actions\Agent\Shift\Network\AddLocationNetwork;
use App\Http\Controllers\Controller;
use App\Http\Requests\NetworkRequest;
use App\Models\Crypto;
use App\Models\FinancialServiceProvider;
use App\Models\Location;
use App\Models\Network;
use App\Utils\Enums\NetworkTypeEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NetworkAPIController extends Controller
{
    /**
     * Display a listing of networks for the authenticated business.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Network::with(['location', 'business', 'agency', 'crypto'])
                ->where('business_code', auth()->user()->business_code);

            // Filter by location if provided
            if ($request->filled('location_code')) {
                $query->where('location_code', $request->location_code);
            }

            // Filter by type if provided
            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }

            $networks = $query->orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => $networks->map(function ($network) {
                    return [
                        'id' => $network->id,
                        'code' => $network->code,
                        'name' => $network->name,
                        'type' => $network->type,
                        'agent_no' => $network->agent_no,
                        'description' => $network->description,
                        'balance' => $network->balance,
                        'balance_currency' => $network->balance_currency,
                        'crypto_balance' => $network->crypto_balance,
                        'exchange_rate' => $network->exchange_rate,
                        'location' => [
                            'code' => $network->location?->code,
                            'name' => $network->location?->name,
                        ],
                        'fsp' => $network->agency ? [
                            'code' => $network->agency->code,
                            'name' => $network->agency->name,
                        ] : null,
                        'crypto' => $network->crypto ? [
                            'code' => $network->crypto->code,
                            'symbol' => $network->crypto->symbol,
                            'name' => $network->crypto->name,
                        ] : null,
                        'created_at' => $network->created_at,
                        'updated_at' => $network->updated_at,
                    ];
                }),
                'message' => 'Networks retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('NetworkAPIController::index - Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve networks',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created network.
     */
    public function store(NetworkRequest $request): JsonResponse
    {
        try {
            Log::info('NetworkAPIController::store - Request data: ' . json_encode($request->validated()));

            $network = AddLocationNetwork::run($request->validated());

            return response()->json([
                'success' => true,
                'data' => $network,
                'message' => 'Network created successfully'
            ], 201);
        } catch (\Exception $e) {
            Log::error('NetworkAPIController::store - Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create network',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified network.
     */
    public function show(string $code): JsonResponse
    {
        try {
            $network = Network::with(['location', 'business', 'agency', 'crypto'])
                ->where('business_code', auth()->user()->business_code)
                ->where('code', $code)
                ->first();

            if (!$network) {
                return response()->json([
                    'success' => false,
                    'message' => 'Network not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $network->id,
                    'code' => $network->code,
                    'name' => $network->name,
                    'type' => $network->type,
                    'agent_no' => $network->agent_no,
                    'description' => $network->description,
                    'balance' => $network->balance,
                    'balance_currency' => $network->balance_currency,
                    'crypto_balance' => $network->crypto_balance,
                    'exchange_rate' => $network->exchange_rate,
                    'location' => [
                        'code' => $network->location?->code,
                        'name' => $network->location?->name,
                    ],
                    'fsp' => $network->agency ? [
                        'code' => $network->agency->code,
                        'name' => $network->agency->name,
                    ] : null,
                    'crypto' => $network->crypto ? [
                        'code' => $network->crypto->code,
                        'symbol' => $network->crypto->symbol,
                        'name' => $network->crypto->name,
                    ] : null,
                    'created_at' => $network->created_at,
                    'updated_at' => $network->updated_at,
                ],
                'message' => 'Network retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('NetworkAPIController::show - Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve network',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified network.
     */
    public function update(NetworkRequest $request, string $code): JsonResponse
    {
        try {
            $network = Network::where('business_code', auth()->user()->business_code)
                ->where('code', $code)
                ->first();

            if (!$network) {
                return response()->json([
                    'success' => false,
                    'message' => 'Network not found'
                ], 404);
            }

            $data = $request->validated();

            // Update network based on type
            if ($data['type'] === NetworkTypeEnum::FINANCE->value) {
                $network->update([
                    'name' => $data['name'],
                    'type' => $data['type'],
                    'location_code' => $data['location_code'],
                    'fsp_code' => $data['fsp_code'],
                    'agent_no' => $data['agent_no'] ?? $network->agent_no,
                    'balance' => $data['balance'] ?? $network->balance,
                    'description' => $data['description'] ?? $network->description,
                    // Clear crypto fields
                    'crypto_code' => null,
                    'crypto_balance' => null,
                    'exchange_rate' => null,
                ]);
            } elseif ($data['type'] === NetworkTypeEnum::CRYPTO->value) {
                $network->update([
                    'name' => $data['name'],
                    'type' => $data['type'],
                    'location_code' => $data['location_code'],
                    'crypto_code' => $data['crypto_code'],
                    'crypto_balance' => $data['crypto_balance'] ?? $network->crypto_balance,
                    'exchange_rate' => $data['exchange_rate'] ?? $network->exchange_rate,
                    'description' => $data['description'] ?? $network->description,
                    // Clear finance fields
                    'fsp_code' => null,
                    'agent_no' => null,
                    'balance' => null,
                    'balance_currency' => null,
                ]);
            }

            $network->load(['location', 'business', 'agency', 'crypto']);

            return response()->json([
                'success' => true,
                'data' => $network,
                'message' => 'Network updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('NetworkAPIController::update - Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update network',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified network.
     */
    public function destroy(string $code): JsonResponse
    {
        try {
            $network = Network::where('business_code', auth()->user()->business_code)
                ->where('code', $code)
                ->first();

            if (!$network) {
                return response()->json([
                    'success' => false,
                    'message' => 'Network not found'
                ], 404);
            }

            $network->delete();

            return response()->json([
                'success' => true,
                'message' => 'Network deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('NetworkAPIController::destroy - Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete network',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available locations for network creation.
     */
    public function locations(): JsonResponse
    {
        try {
            $locations = Location::where('business_code', auth()->user()->business_code)
                ->select('code', 'name', 'address')
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $locations,
                'message' => 'Locations retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('NetworkAPIController::locations - Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve locations',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available financial service providers.
     */
    public function financialServiceProviders(): JsonResponse
    {
        try {
            $user = auth()->user();
            $countryCode = $user->business->country_code ?? null;

            $fsps = FinancialServiceProvider::when($countryCode, function ($query) use ($countryCode) {
                    return $query->where('country_code', $countryCode);
                })
                ->select('code', 'name', 'country_code')
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $fsps,
                'message' => 'Financial service providers retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('NetworkAPIController::financialServiceProviders - Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve financial service providers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available crypto currencies.
     */
    public function cryptos(): JsonResponse
    {
        try {
            $cryptos = Crypto::select('code', 'name', 'symbol', 'current_price')
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $cryptos,
                'message' => 'Crypto currencies retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('NetworkAPIController::cryptos - Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve crypto currencies',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get network types.
     */
    public function types(): JsonResponse
    {
        try {
            $types = collect(NetworkTypeEnum::cases())->map(function ($type) {
                return [
                    'value' => $type->value,
                    'label' => $type->label(),
                    'color' => $type->color(),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $types,
                'message' => 'Network types retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('NetworkAPIController::types - Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve network types',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

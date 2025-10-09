<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Shift;
use App\Models\ShiftTransaction;
use Illuminate\Http\Request;

class MockTransactionAPIController extends Controller
{
    /**
     * Get all transactions of a random business with pagination.
     * Authentication required.
     */
    public function index(Request $request)
    {
        try {
            // Get a random business that has at least 5 shift transactions
            $business = Business::withoutGlobalScopes()
                ->whereHas('shift_transactions', function ($query) {
                    $query->withoutGlobalScopes();
                }, '>=', 5)
                ->inRandomOrder()
                ->first();

            if (!$business) {
                return responder()->error('No businesses with sufficient transactions found', 404);
            }

            // Get transactions for this business without global scopes
            $transactions = ShiftTransaction::withoutGlobalScopes()
                ->where('business_code', $business->code)
                ->with(['network.agency', 'shift', 'location'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            return responder()->success([
                'business' => [
                    'code' => $business->code,
                    'name' => $business->business_name,
                ],
                'transactions' => $transactions->items(),
                'pagination' => [
                    'current_page' => $transactions->currentPage(),
                    'total_pages' => $transactions->lastPage(),
                    'total_items' => $transactions->total(),
                    'per_page' => $transactions->perPage(),
                ]
            ]);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage(), 500);
        }
    }

    /**
     * Get transactions of a specific shift with pagination.
     * Authentication required.
     */
    public function shiftTransactions(Request $request, string $shiftId)
    {
        try {
            // Get the shift without global scopes
            $shift = Shift::withoutGlobalScopes()
                ->with(['user', 'location', 'business'])
                ->findOrFail($shiftId);

            // Get transactions for this shift
            $transactions = ShiftTransaction::withoutGlobalScopes()
                ->where('shift_id', $shiftId)
                ->with(['network.agency', 'location'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            return responder()->success([
                'shift' => [
                    'id' => $shift->id,
                    'status' => $shift->status,
                    'user' => $shift->user ? [
                        'code' => $shift->user->code,
                    ] : null,
                    'location' => $shift->location ? [
                        'code' => $shift->location->code,
                        'name' => $shift->location->name,
                    ] : null,
                    'business' => $shift->business ? [
                        'code' => $shift->business->code,
                        'name' => $shift->business->business_name,
                    ] : null,
                    'created_at' => $shift->created_at,
                ],
                'transactions' => $transactions->items(),
                'pagination' => [
                    'current_page' => $transactions->currentPage(),
                    'total_pages' => $transactions->lastPage(),
                    'total_items' => $transactions->total(),
                    'per_page' => $transactions->perPage(),
                ]
            ]);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage(), 404);
        }
    }

    /**
     * Get 10 random transactions.
     * Authentication required.
     */
    public function recent()
    {
        try {
            // Get 10 random transactions
            $transactions = ShiftTransaction::withoutGlobalScopes()
                ->with(['network.agency', 'shift', 'location', 'business'])
                ->inRandomOrder()
                ->limit(10)
                ->get();

            return responder()->success([
                'transactions' => $transactions,
                'count' => $transactions->count(),
            ]);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage(), 500);
        }
    }

    /**
     * Get random shifts with pagination.
     * Authentication required.
     */
    public function randomShifts(Request $request)
    {
        try {
            // Get random shifts with their relationships
            $shifts = Shift::withoutGlobalScopes()
                ->with(['user', 'location', 'business', 'shiftNetworks.network.agency'])
                ->inRandomOrder()
                ->paginate(15);

            return responder()->success([
                'shifts' => $shifts->items(),
                'pagination' => [
                    'current_page' => $shifts->currentPage(),
                    'total_pages' => $shifts->lastPage(),
                    'total_items' => $shifts->total(),
                    'per_page' => $shifts->perPage(),
                ]
            ]);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage(), 500);
        }
    }

    /**
     * Get transactions of a random shift with pagination.
     * Authentication required.
     */
    public function randomShiftTransactions(Request $request)
    {
        try {
            // Get a random shift that has at least 1 transaction
            $shift = Shift::withoutGlobalScopes()
                ->whereHas('transactions', function ($query) {
                    $query->withoutGlobalScopes();
                }, '>=', 1)
                ->inRandomOrder()
                ->first();

            if (!$shift) {
                return responder()->error('No shifts with transactions found', 404);
            }

            // Get transactions for this shift
            $transactions = ShiftTransaction::withoutGlobalScopes()
                ->where('shift_id', $shift->id)
                ->with(['network.agency', 'location'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            return responder()->success([
                'shift' => [
                    'id' => $shift->id,
                    'status' => $shift->status,
                    'user' => $shift->user ? [
                        'code' => $shift->user->code,
                    ] : null,
                    'location' => $shift->location ? [
                        'code' => $shift->location->code,
                        'name' => $shift->location->name,
                    ] : null,
                    'business' => $shift->business ? [
                        'code' => $shift->business->code,
                        'name' => $shift->business->business_name,
                    ] : null,
                    'created_at' => $shift->created_at,
                ],
                'transactions' => $transactions->items(),
                'pagination' => [
                    'current_page' => $transactions->currentPage(),
                    'total_pages' => $transactions->lastPage(),
                    'total_items' => $transactions->total(),
                    'per_page' => $transactions->perPage(),
                ]
            ]);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage(), 500);
        }
    }
}

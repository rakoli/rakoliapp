<?php

namespace App\Http\Controllers\Api;

use App\Actions\Agent\Shift\AddExpenseTransaction;
use App\Actions\Agent\Shift\AddIncomeTransaction;
use App\Actions\Agent\Shift\AddLoan;
use App\Actions\Agent\Shift\AddTransaction;
use App\Actions\Agent\Shift\CloseShift;
use App\Actions\Agent\Shift\OpenShift;
use App\Actions\Agent\Shift\PayLoanAction;
use App\Actions\Agent\Shift\TransferBalance;
use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Utils\Enums\LoanPaymentStatusEnum;
use App\Utils\Enums\NetworkTypeEnum;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShiftAPIController extends Controller
{
    /**
     * Display a listing of shifts.
     */
    public function index()
    {
        try {
            $shifts = Shift::query()
                ->with(['user', 'location'])
                ->where('business_code', auth()->user()->business_code)
                ->orderBy('created_at', 'desc')
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
     * Store a newly created shift (Open Shift).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cash_at_hand' => 'required|numeric|min:0',
            'location_code' => 'required|exists:locations,code',
            'notes' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        try {
            // Check if there's already an open shift
            if (Shift::query()->where('status', ShiftStatusEnum::OPEN)->exists()) {
                return responder()->error('Close opened shift to continue', 422);
            }

            $shift = OpenShift::run(
                cashAtHand: $validated['cash_at_hand'],
                locationCode: $validated['location_code'],
                notes: $validated['notes'] ?? null,
                description: $validated['description'] ?? null
            );

            return responder()->success([
                'message' => 'Shift opened successfully',
                'shift' => $shift->load(['user', 'location', 'shiftNetworks.network.agency'])
            ]);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage(), 422);
        }
    }

    /**
     * Display the specified shift with details.
     */
    public function show(string $id)
    {
        try {
            $shift = Shift::with([
                'user',
                'location',
                'transactions.network.agency',
                'cashTransactions',
                'shiftNetworks.network.agency',
                'loans'
            ])->findOrFail($id);

            $balances = shiftBalances(shift: $shift);

            return responder()->success([
                'shift' => $shift,
                'balances' => $balances,
                'summary' => [
                    'total_transactions' => $shift->transactions->count(),
                    'total_cash_transactions' => $shift->cashTransactions->count(),
                    'total_loans' => $shift->loans->count(),
                    'unpaid_loans' => $shift->loans->where('status', LoanPaymentStatusEnum::UN_PAID)->count(),
                ]
            ]);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage(), 404);
        }
    }

    /**
     * Close the specified shift.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'closing_balance' => 'required|numeric',
            'description' => 'required|string',
            'notes' => 'nullable|string',
            'tills' => 'required|array',
            'total_shorts' => 'nullable|numeric',
            'short_type' => 'nullable|string',
            'short_description' => 'nullable|string',
        ]);

        try {
            $shift = Shift::findOrFail($id);

            if ($shift->status !== ShiftStatusEnum::OPEN) {
                return responder()->error('Shift is not open', 422);
            }

            $validated['status'] = ShiftStatusEnum::CLOSED;

            CloseShift::run(shift: $shift, data: $validated);

            return responder()->success([
                'message' => 'Shift closed successfully',
                'shift' => $shift->fresh(['user', 'location'])
            ]);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage(), 422);
        }
    }

    /**
     * Get current open shift.
     */
    public function current()
    {
        try {
            $shift = Shift::query()
                ->where('status', ShiftStatusEnum::OPEN)
                ->where('business_code', auth()->user()->business_code)
                ->with(['user', 'location', 'shiftNetworks.network.agency'])
                ->first();

            if (!$shift) {
                return responder()->error('No open shift found', 404);
            }

            $balances = shiftBalances(shift: $shift);

            return responder()->success([
                'shift' => $shift,
                'balances' => $balances,
            ]);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage(), 500);
        }
    }

    /**
     * Add income transaction.
     */
    public function addIncome(Request $request, string $id)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'source' => 'required|in:TILL,CASH',
            'network_code' => 'nullable|exists:networks,code',
            'description' => 'required|string',
            'notes' => 'nullable|string',
            'crypto' => 'nullable|numeric',
            'exchange_rate' => 'nullable|numeric'
        ]);

        try {
            $shift = Shift::findOrFail($id);

            if ($shift->status !== ShiftStatusEnum::OPEN) {
                return responder()->error('Shift is not open', 422);
            }

            if (! $shift->created_at->isToday()) {
                return responder()->error('You must close previous Day shift to make this Transaction', 422);
            }

            $validated['category'] = TransactionCategoryEnum::INCOME;
            $validated['type'] = TransactionTypeEnum::MONEY_IN->value;

            AddIncomeTransaction::run($shift, $validated);

            return responder()->success([
                'message' => 'Income transaction added successfully'
            ]);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage(), 422);
        }
    }

    /**
     * Add expense transaction.
     */
    public function addExpense(Request $request, string $id)
    {
        $validated = $request->validate([
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'source' => 'required|in:TILL,CASH',
            'network_code' => 'required_if:source,TILL|exists:networks,code',
            'description' => 'required|string',
            'notes' => 'nullable|string',
            'crypto' => 'nullable|numeric',
            'exchange_rate' => 'nullable|numeric'
        ]);

        try {
            $shift = Shift::findOrFail($id);

            if ($shift->status !== ShiftStatusEnum::OPEN) {
                return responder()->error('Shift is not open', 422);
            }

            if (! $shift->created_at->isToday()) {
                return responder()->error('You must close previous Day shift to make this Transaction', 422);
            }

            if (! checkBalance($shift, $request)) {
                return responder()->error('Insufficient balance', 422);
            }

            $validated['category'] = TransactionCategoryEnum::EXPENSE;
            $validated['type'] = TransactionTypeEnum::MONEY_OUT->value;

            AddExpenseTransaction::run(shift: $shift, data: $validated);

            return responder()->success([
                'message' => 'Expense transaction added successfully'
            ]);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage(), 422);
        }
    }

    /**
     * Add regular transaction.
     */
    public function addTransaction(Request $request, string $id)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'network_code' => 'required|exists:networks,code',
            'type' => 'required|in:IN,OUT',
            'description' => 'required|string',
            'crypto' => 'nullable|numeric',
            'exchange_rate' => 'nullable|numeric',
            'fee' => 'nullable|numeric'
        ]);

        try {
            $shift = Shift::findOrFail($id);

            if ($shift->status !== ShiftStatusEnum::OPEN) {
                return responder()->error('Shift is not open', 422);
            }

            if (! $shift->created_at->isToday()) {
                return responder()->error('You must close previous Day shift to make this Transaction', 422);
            }

            $validated['category'] = TransactionCategoryEnum::GENERAL;

            AddTransaction::run(shift: $shift, data: $validated);

            return responder()->success([
                'message' => 'Transaction added successfully'
            ]);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage(), 422);
        }
    }

    /**
     * Transfer balance between tills.
     */
    public function transferBalance(Request $request, string $id)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'network_code' => 'required|exists:networks,code',
            'destination_till' => 'required|exists:networks,code',
            'description' => 'required|string',
        ]);

        try {
            $shift = Shift::findOrFail($id);

            if ($shift->status !== ShiftStatusEnum::OPEN) {
                return responder()->error('Shift is not open', 422);
            }

            if (! $shift->created_at->isToday()) {
                return responder()->error('You must close previous Day shift to make this Transaction', 422);
            }

            $validated['category'] = TransactionCategoryEnum::GENERAL;

            TransferBalance::run(shift: $shift, data: $validated);

            return responder()->success([
                'message' => 'Balance transferred successfully'
            ]);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage(), 422);
        }
    }

    /**
     * Add loan.
     */
    public function addLoan(Request $request, string $id)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'source' => 'required|in:TILL,CASH',
            'name' => 'required|string',
            'type' => 'required|in:IN,OUT',
            'network_code' => 'required_if:source,TILL|exists:networks,code',
            'notes' => 'nullable|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        try {
            $shift = Shift::findOrFail($id);

            if ($shift->status !== ShiftStatusEnum::OPEN) {
                return responder()->error('Shift is not open', 422);
            }

            // Check subscription limits if needed
            if (!validateSubscription("loan management", Loan::where('business_code', auth()->user()->business_code)->count())) {
                return responder()->error("You have exceeded loan limit, Please upgrade your plan", 403);
            }

            $validated['category'] = TransactionCategoryEnum::GENERAL;

            $loan = AddLoan::run(shift: $shift, data: $validated);

            return responder()->success([
                'message' => 'Loan added successfully',
                'loan' => $loan
            ]);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage(), 422);
        }
    }

    /**
     * Pay loan.
     */
    public function payLoan(Request $request, string $shiftId, string $loanId)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'source' => 'required|in:TILL,CASH',
            'network_code' => 'required_if:source,TILL|exists:networks,code',
            'deposited_at' => 'required|date',
            'notes' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        try {
            $shift = Shift::findOrFail($shiftId);
            $loan = Loan::findOrFail($loanId);

            if ($loan->shift_id != $shift->id) {
                return responder()->error('Loan does not belong to this shift', 422);
            }

            $validated['category'] = TransactionCategoryEnum::GENERAL;

            PayLoanAction::run(loan: $loan, data: $validated);

            return responder()->success([
                'message' => 'Loan paid successfully'
            ]);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage(), 422);
        }
    }

    /**
     * Get shift loans.
     */
    public function loans(string $id)
    {
        try {
            $shift = Shift::findOrFail($id);

            $loans = Loan::query()
                ->whereBelongsTo($shift, 'shift')
                ->with('location', 'shift', 'network.agency', 'user')
                ->latest()
                ->get();

            return responder()->success([
                'loans' => $loans
            ]);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage(), 404);
        }
    }

    /**
     * Get shift tills/networks.
     */
    public function tills(string $id)
    {
        try {
            $shift = Shift::findOrFail($id);

            $tills = ShiftNetwork::query()
                ->where('shift_id', $shift->id)
                ->with('network.agency')
                ->get();

            return responder()->success([
                'tills' => $tills
            ]);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage(), 404);
        }
    }

    /**
     * Get shift transactions.
     */
    public function transactions(Request $request, string $id)
    {
        try {
            $shift = Shift::findOrFail($id);

            $type = $request->get('type', 'finance'); // finance or crypto
            $isCash = $request->boolean('is_cash', false);

            if ($isCash) {
                $transactions = $shift->cashTransactions()
                    ->with('location', 'user', 'network.agency')
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
            } else {
                $query = $shift->transactions()
                    ->select('shift_transactions.*')
                    ->join('networks', 'networks.code', 'shift_transactions.network_code')
                    ->where('networks.type', $type === 'crypto' ? NetworkTypeEnum::CRYPTO : NetworkTypeEnum::FINANCE)
                    ->with('location', 'user', 'network.agency');

                $transactions = $query->orderBy('created_at', 'desc')->paginate(15);
            }

            return responder()->success([
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
     * Get available locations for opening shift.
     */
    public function locations()
    {
        try {
            $locations = Location::query()
                ->whereHas('users', fn($query) => $query->where('user_code', auth()->user()->code))
                ->with(['networks.agency', 'activeLoans'])
                ->get()
                ->map(fn(Location $location) => [
                    'code' => $location->code,
                    'name' => $location->name,
                    'balance' => $location->balance,
                    'networks' => $location->networks->map(fn(Network $network) => [
                        'code' => $network->code,
                        'name' => $network->type == NetworkTypeEnum::FINANCE->value
                            ? $network->agency?->name
                            : $network->crypto?->name,
                        'balance' => $network->balance
                    ]),
                    'loans' => $location->activeLoans->map(fn(Loan $loan) => [
                        'source' => $loan->network ? $loan->network->agency?->name : "Cash",
                        'type' => $loan->type->label(),
                        'balance' => $loan->balance
                    ]),
                ]);

            return responder()->success([
                'locations' => $locations
            ]);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return responder()->error('Shifts cannot be deleted', 405);
    }
}

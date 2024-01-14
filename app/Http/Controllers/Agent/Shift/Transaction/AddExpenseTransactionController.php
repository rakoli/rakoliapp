<?php

namespace App\Http\Controllers\Agent\Shift\Transaction;

use App\Actions\Agent\Shift\AddIncomeExpenseTransaction;
use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Http\Request;

class AddExpenseTransactionController extends Controller
{
    public function __invoke(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'amount' => 'required',
            'location_code' => 'required|exists:locations,code',
            'till_code' => 'required|exists:networks,code',
            'notes' => 'required|string',
        ],
            [
                'location_code.required' => 'Location is required',
                'till_code.required' => 'Network is required',
            ]);

        try {
            $validated['category'] = TransactionCategoryEnum::EXPENSE;
            $validated['type'] = TransactionTypeEnum::MONEY_OUT->value;

            AddIncomeExpenseTransaction::run(shift: $shift , data: $validated);

            return response()
                ->json([
                    'message' => 'Expense Added successfully',
                ]);

        } catch (\Exception|\Throwable $e) {
            return response()
                ->json([
                    'message' => 'Expense could not be added',
                ], 422);
        }
    }
}

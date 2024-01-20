<?php

namespace App\Http\Controllers\Agent\Shift\Transaction;

use App\Actions\Agent\Shift\AddExpenseTransaction;
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
            'description' => 'required|string',
        ]);

        try {
            $validated['category'] = TransactionCategoryEnum::EXPENSE;
            $validated['type'] = TransactionTypeEnum::MONEY_OUT->value;

            AddExpenseTransaction::run(shift: $shift, data: $validated);

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

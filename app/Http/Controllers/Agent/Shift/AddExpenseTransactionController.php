<?php

namespace App\Http\Controllers\Agent\Shift;

use App\Actions\Agent\Shift\AddIncomeExpenseTransaction;
use App\Http\Controllers\Controller;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Http\Request;

class AddExpenseTransactionController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required',
            'location_code' => 'required|exists:locations,code',
            'notes' => 'required|string',
        ],
        [
            'location_code.required' => 'Location is required',
        ]);

        try {
            $validated['category'] =  TransactionCategoryEnum::EXPENSE;
            $validated['type'] =  TransactionTypeEnum::MONEY_OUT->value;

            AddIncomeExpenseTransaction::run($validated);

            return response()
                ->json([
                    'message' => "Expense Added successfully"
                ]);

        }
        catch (\Exception|\Throwable $e)
        {
            return response()
                ->json([
                    'message' => "Expense could not be added"
                ], 422);
        }
    }
}

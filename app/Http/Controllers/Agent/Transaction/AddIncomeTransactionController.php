<?php

namespace App\Http\Controllers\Agent\Transaction;

use App\Actions\Agent\Shift\AddIncomeExpenseTransaction;
use App\Http\Controllers\Controller;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Http\Request;

class AddIncomeTransactionController extends Controller
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
            $validated['category'] =  TransactionCategoryEnum::INCOME;
            $validated['type'] =  TransactionTypeEnum::MONEY_IN->value;

            AddIncomeExpenseTransaction::run($validated);

            return response()
                ->json([
                    'message' => "Income Added successfully"
                ]);

        }
        catch (\Exception|\Throwable $e)
        {
            return response()
                ->json([
                    'message' => "Income could not be added"
                ], 422);
        }
    }
}

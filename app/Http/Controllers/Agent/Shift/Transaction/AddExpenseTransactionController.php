<?php

namespace App\Http\Controllers\Agent\Shift\Transaction;

use App\Actions\Agent\Shift\AddExpenseTransaction;
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
            'source' => 'required',
            'network_code' => 'nullable',
            'description' => 'required|string',
            'notes' => 'nullable|string',
            'crypto' => 'nullable|numeric',
            'exchange_rate' => 'nullable|numeric'
        ]);

        try {

            throw_if(! $shift->created_at->isToday(), new \Exception('You must close previous Day shift to make this Transaction'));

            throw_if(! checkBalance($shift, $request), new \Exception('Insuffcient balance'));

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
                    'message' => $e->getMessage(),
                ], 422);
        }
    }
}

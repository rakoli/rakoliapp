<?php

namespace App\Http\Controllers\Agent\Shift\Transaction;

use App\Actions\Agent\Shift\AddIncomeTransaction;
use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Http\Request;

class AddIncomeTransactionController extends Controller
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

            $validated['category'] = TransactionCategoryEnum::INCOME;
            $validated['type'] = TransactionTypeEnum::MONEY_IN->value;

            AddIncomeTransaction::run($shift, $validated);

            return response()
                ->json([
                    'message' => 'Cash In Added successfully',
                ]);

        } catch (\Exception|\Throwable $e) {
            return response()
                ->json([
                    'message' => 'Cash In could not be added'.$e->getMessage(),
                ], 422);
        }
    }
}

<?php

namespace App\Http\Controllers\Agent\Shift\Transaction;

use App\Actions\Agent\Shift\AddExpenseTransaction;
use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddExpenseTransactionController extends Controller
{
    public function __invoke(Request $request, Shift $shift)
    {
        Log::info(print_r($request->all(),true));
        $validated = $request->validate([
            'category' => 'required',
            'amount' => 'required',
            'source' => 'required',
            'network_code' => 'required_if:source,TILL',
            'description' => 'required|string',
            'notes' => 'nullable|string',
            'crypto' => 'nullable|numeric',
            'exchange_rate' => 'nullable|numeric'
        ]);

        try {

            throw_if(! $shift->created_at->isToday(), new \Exception('You must close previous Day shift to make this Transaction'));

            throw_if(! checkBalance($shift, $request), new \Exception('Insuffcient balance'));

            if($validated['category'] == "expense"){
                $msg = "Expense recorded successfully";
            } else {
                $msg = "Cash Out recorded successfully";
            }
            $validated['category'] = TransactionCategoryEnum::EXPENSE;

            $validated['type'] = TransactionTypeEnum::MONEY_OUT->value;

            AddExpenseTransaction::run(shift: $shift, data: $validated);

            return response()
                ->json([
                    'message' => $msg,
                ]);

        } catch (\Exception|\Throwable $e) {
            return response()
                ->json([
                    'message' => $e->getMessage(),
                ], 422);
        }
    }
}

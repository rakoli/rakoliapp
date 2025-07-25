<?php

namespace App\Http\Controllers\Agent\Shift\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Utils\Enums\TransactionCategoryEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\New_;

class TransferBalanceController extends Controller
{
    public function __invoke(Request $request, Shift $shift)
    {
        Log::info("TransferBalanceController :: Request Data ::".print_r($request->all(),true));
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'network_code' => 'required|exists:networks,code',
            'destination_till' => 'required|exists:networks,code',
            'description' => 'required',
        ]);

        $validated['category'] = TransactionCategoryEnum::GENERAL;
        $request->merge(['source' => "TILL"]);


        try {
            
            throw_if(! $shift->created_at->isToday(), new \Exception('You must close previous Day shift to make this Transaction'));

            throw_if($request->network_code == $request->destination_till, new \Exception('You can not transfer to same till balance'));

            throw_if(! checkBalance($shift, $request), new \Exception('Insuffcient balance'));

            \App\Actions\Agent\Shift\TransferBalance::run(shift: $shift, data: $validated);
            
            return response()
                ->json([
                    'message' => __('general.LBL_TRANSACTION_ADDED_SUCCESSFULLY'),
                ]);

        } catch (\Exception|\Throwable $e) {
            Log::info("TransferBalanceController :: Exception ::".print_r($e->getMessage(),true));

            return response()
                ->json([
                    'message' => $e->getMessage(),
                ], 422);
        }

    }
}

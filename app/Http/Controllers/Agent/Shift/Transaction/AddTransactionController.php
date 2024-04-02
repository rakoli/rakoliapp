<?php

namespace App\Http\Controllers\Agent\Shift\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Utils\Enums\TransactionCategoryEnum;
use Illuminate\Http\Request;

class AddTransactionController extends Controller
{
    public function __invoke(Request $request, Shift $shift)
    {

        $validated = $request->validate([
            'amount' => 'required|numeric',
            'network_code' => 'required|exists:networks,code',
            'type' => 'required',
            'description' => 'required',
        ], [
            'network_code.required' => 'Network is required',
            'network_code.exists' => 'Network does not exists',
            'type.required' => 'Transaction Type is required',
        ]);

        $validated['category'] = TransactionCategoryEnum::GENERAL;

        // try {

            throw_if(! $shift->created_at->isToday(), new \Exception('You must close previous Day shift to make this Transaction'));

            \App\Actions\Agent\Shift\AddTransaction::run(shift: $shift, data: $validated);
            
            return response()
                ->json([
                    'message' => 'Transaction Added successfully',
                ]);

        // } catch (\Exception|\Throwable $e) {

        //     return response()
        //         ->json([
        //             'message' => $e->getMessage(),
        //         ], 422);
        // }

    }
}

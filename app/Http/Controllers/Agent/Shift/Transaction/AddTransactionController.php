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
            'location_code' => 'required|exists:locations,code',
            'till_code' => 'required|exists:networks,code',
            'type' => 'required',
            'notes' => 'required',
        ], [
            'location_code.required' => 'Location is required',
            'location_code.exists' => 'Location does not exists',
            'type.required' => 'Transaction Type is required',
        ]);

        $validated['category'] = TransactionCategoryEnum::GENERAL;

        try {
            \App\Actions\Agent\Shift\AddTransaction::run(shift: $shift, data: $validated);

            return response()
                ->json([
                    'message' => 'Transaction Added successfully',
                ]);

        } catch (\Exception|\Throwable $e) {



            return response()
                ->json([
                    'message' => 'Transaction could not be added',
                ], 422);
        }

    }
}

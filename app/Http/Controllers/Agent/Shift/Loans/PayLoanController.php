<?php

namespace App\Http\Controllers\Agent\Shift\Loans;

use App\Actions\Agent\Shift\PayLoanAction;
use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Shift;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionCategoryEnum;
use Illuminate\Http\Request;

class PayLoanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Shift $shift, Loan $loan)
    {
        $validated = $request->validate([
            'amount' => 'required',
            'source' => 'required',
            'network_code' => 'required_if:source,TILL',
            'deposited_at' => 'required',
            'notes' => 'nullable',
            'description' => 'nullable',
        ]);

        try {
            throw_if($loan->shift_id != $shift->id, new \Exception('Loan does not belong to this Shift'));

            throw_if(
                $shift->status != ShiftStatusEnum::OPEN, 
                new \Exception('You cannot transact without an open shift')
            );


            $validated['category'] = TransactionCategoryEnum::GENERAL;

            PayLoanAction::run(
                loan: $loan,
                data: $validated
            );

            return response()
                ->json([
                    'message' => 'Loan Paid successfully',
                ], 201);

        } catch (\Exception $e) {
            return response()
                ->json([
                    'message' => $e->getMessage(),
                ], 422);

        }
    }
}

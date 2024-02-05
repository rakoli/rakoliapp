<?php

namespace App\Http\Controllers\Agent\Shift\Loans;

use App\Actions\Agent\Shift\PayLoanAction;
use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Shift;
use Illuminate\Http\Request;

class PayLoanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Shift $shift , Loan $loan)
    {
        $validated = $request->validate([
            'amount' => 'required',
            'payment_method' => 'required',
            'deposited_at' => 'required',
            'notes' => 'nullable',
            'description' => 'nullable',
        ]);

        try {

            PayLoanAction::run(
                loan: $loan,
                data: $validated
            );

            return response()
                ->json([
                    'message' => 'Loan Paid successfully',
                ], 201);

        }
        catch (\Exception $e) {
            return response()
                ->json([
                    'message' => $e->getMessage(),
                ], 422);

        }
    }
}

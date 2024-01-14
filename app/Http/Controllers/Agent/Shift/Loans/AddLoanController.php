<?php

namespace App\Http\Controllers\Agent\Shift\Loans;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddLoanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $validated = $request->validate([
            'amount' => 'required',
            'network_code' => 'required|exists:networks,code',
            'location_code' => 'required|exists:locations,code',
            'type' => 'required',
            'notes' => 'required',
        ], [
            'type.required' => 'Transaction Type is Required',
            'location_code.required' => 'Location is Required',
            'network_code.required' => 'Network is Required',
        ]);

        try {

            \App\Actions\Agent\Shift\AddLoan::run($validated);

            return response()
                ->json([
                    'message' => 'Loan Added successfully',
                ], 201);

        } catch (\Exception $e) {
            return response()
                ->json([
                    'message' => 'Something went wrong',
                ], 422);

        }
    }
}

<?php

namespace App\Http\Controllers\Agent\Shift\Loans;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Utils\Enums\TransactionCategoryEnum;
use Illuminate\Http\Request;

class AddLoanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Shift $shift)
    {

        $validated = $request->validate([
            'amount' => 'required',
            'network_code' => 'required|exists:networks,code',
            'type' => 'required',
            'notes' => 'nullable|string|max:255',
            'description' => 'required|string|max:255',
        ], [
            'type.required' => 'Transaction Type is Required',
            'network_code.required' => 'Network is Required',
        ]);




        try {
            $validated['category'] = TransactionCategoryEnum::GENERAL;

            \App\Actions\Agent\Shift\AddLoan::run(shift: $shift , data:$validated);

            return response()
                ->json([
                    'message' => 'Loan Added successfully',
                ], 201);

        } catch (\Exception $e) {
            return response()
                ->json([
                    'message' => 'Something went wrong' . $e->getMessage(),
                ], 422);

        }
    }
}

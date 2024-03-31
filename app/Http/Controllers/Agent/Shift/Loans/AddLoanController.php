<?php

namespace App\Http\Controllers\Agent\Shift\Loans;

use App\Actions\Agent\Shift\AddLoan;
use App\Http\Controllers\Controller;
use App\Models\Loan;
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
        if(!validateSubscription("loan management",Loan::where('business_code', auth()->user()->business_code)->count())){
            return response()->json([
                'message' => "You have exceeded loan limit, Please upgrade your plan",
            ], 403);
        }


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

            throw_if(
                ! $shift->created_at->isToday(),
                new \Exception('You must close previous Day shift to make this Transaction')
            );

            $validated['category'] = TransactionCategoryEnum::GENERAL;

            AddLoan::run(shift: $shift, data: $validated);

            return response()
                ->json([
                    'message' => 'Loan Added successfully',
                ], 201);

        } catch (\Exception $e) {
            return response()
                ->json([
                    'message' => 'Something went wrong'.$e->getMessage(),
                ], 422);

        }
    }
}

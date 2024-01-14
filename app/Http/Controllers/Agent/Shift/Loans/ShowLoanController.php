<?php

namespace App\Http\Controllers\Agent\Shift\Loans;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Utils\Datatables\Agent\Shift\LoanPaymentDatatable;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;

class ShowLoanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Loan $loan, LoanPaymentDatatable $paymentDatatable, Builder $datatableBuilder)
    {
        if ($request->ajax()) {
            return $paymentDatatable->index($loan);
        }

        return view('agent.agency.loans.show')->with([
            'loan' => $loan,
            'datatableHtml' => $paymentDatatable->columns($datatableBuilder),

        ]);
    }
}

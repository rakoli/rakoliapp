<?php

namespace App\Http\Controllers\Agent\Shift\Loans;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Utils\Datatables\Agent\Shift\LoanDatatable;
use App\Utils\Datatables\Agent\Shift\LoanPaymentDatatable;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;

class LoanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request, LoanDatatable $loanDatatable, Builder $datatableBuilder)
    {
        if ($request->ajax())
        {
            return $loanDatatable->index();
        }

        return view('agent.agency.loans')->with([
            'datatableHtml' => $loanDatatable->columns($datatableBuilder)
        ]);
    }

    public function pay(Request $request, Loan $loan, LoanPaymentDatatable $paymentDatatable, Builder $datatableBuilder)
    {
        if ($request->ajax())
        {
            return $paymentDatatable->index($loan);
        }

        return view('agent.agency.loans.pay')->with([
            'loan' => $loan,
            'datatableHtml' => $paymentDatatable->columns($datatableBuilder)

        ]);
    }
}


<?php

namespace App\Http\Controllers\Agent\Shift;

use App\Http\Controllers\Controller;
use App\Utils\Datatables\Agent\Shift\LoanDatatable;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;

class LoanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, LoanDatatable $loanDatatable, Builder $datatableBuilder)
    {
        if ($request->ajax())
        {
            return $loanDatatable->index();
        }

        return view('agent.agency.loans')->with([
            'datatableHtml' => $loanDatatable->columns($datatableBuilder)
        ]);
    }
}


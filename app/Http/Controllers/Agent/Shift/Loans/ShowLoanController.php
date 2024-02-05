<?php

namespace App\Http\Controllers\Agent\Shift\Loans;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Utils\Datatables\Agent\Shift\LoanPaymentDatatable;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;

class ShowLoanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Shift $shift, Loan $loan, LoanPaymentDatatable $paymentDatatable, Builder $datatableBuilder)
    {

        if ($request->ajax()) {
            return $paymentDatatable->index($loan);
        }

        $tills = ShiftNetwork::query()->where('shift_id', $shift->id)->with('network.agency');

        $totalBalance = $shift->cash_end + $tills->sum('balance_new');

        return view('agent.agency.loans.show')->with([
            'loan' => $loan,
            'shift' => $shift,
            'totalBalance' => $totalBalance,
            'tills' => $tills->cursor(),
            'datatableHtml' => $paymentDatatable->columns($datatableBuilder),

        ]);
    }
}

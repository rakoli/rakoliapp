<?php

namespace App\Http\Controllers\Agent\Shift\Loans;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Utils\Datatables\Agent\Shift\LoanDatatable;
use App\Utils\Enums\ShiftStatusEnum;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Html\Builder;

class LoanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request, LoanDatatable $loanDatatable, Builder $datatableBuilder)
    {

        if ($request->ajax()) {
            return $loanDatatable->index();
        }

        $hasOpenShift = ! Shift::query()->where('status', ShiftStatusEnum::OPEN)->exists();

        $locations = Location::query()->cursor();
        $networks = Network::query()->cursor();

        return view('agent.agency.loans.index')->with([
            'datatableHtml' => $loanDatatable->columns($datatableBuilder),
            'locations' => $locations,
            'networks' => $networks,
            'hasOpenShift' => $hasOpenShift,
        ]);
    }

    public function exportStatement($shift,$id) {
        Log::info('generate_receipt_pdf starts');
        $loan = Loan::with(['network','payments','payments.network'])->where('id',$id)->first()->toArray();
        $pdf = Pdf::loadView('agent.agency.loans.statement', array('loan' => $loan));
        return $pdf->stream($loan['code'].".pdf");
    }

    public function getStatement() {
        Log::info('generate_receipt_pdf starts');
        $loans = Loan::with(['network','user'])->orderBy('id')->get();
        $data['total_credit'] = 0;
        $data['total_paid'] = 0;
        foreach($loans as $key => $loan) {
            $data['entries'][$key]['created_at'] = $loan->created_at;
            $data['entries'][$key]['network'] = $loan->network ? $loan->network->name : "CASH";
            $data['entries'][$key]['user'] = $loan->user ? $loan->user->FullName : " - ";
            $data['entries'][$key]['credit'] = $loan->type == "IN" ? 0 : $loan->balance;
            $data['entries'][$key]['paid'] = $loan->type == "OUT" ? $loan->balance : 0;
            $data['total_credit'] += $data['entries'][$key]['credit']; 
            $data['total_paid'] += $data['entries'][$key]['paid']; 
        }
        $pdf = Pdf::loadView('agent.agency.loans.loans_statement', array('data' => $data));
        return $pdf->download("loan_statement_".time().".pdf");
    }

}

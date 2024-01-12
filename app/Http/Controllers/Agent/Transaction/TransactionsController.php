<?php

namespace App\Http\Controllers\Agent\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Network;
use App\Utils\Datatables\Agent\Shift\ShiftTransactionDatatable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;

class TransactionsController extends Controller
{

    public function __invoke(Request $request, Builder $datatableBuilder, ShiftTransactionDatatable $transactionDatatable): View|JsonResponse
    {


        if ($request->ajax()) {


            return $transactionDatatable->index(isToday: true);
        }

        $dataTableHtml = $transactionDatatable->columns(datatableBuilder: $datatableBuilder);



        $tills = Network::query()->with('agency')->cursor();

        $locations = Location::query()->cursor();


        return view('agent.agency.transactions',[
            'dataTableHtml' => $dataTableHtml,
            'locations' => $locations,
            'tills' => $tills,
        ]);
    }
}

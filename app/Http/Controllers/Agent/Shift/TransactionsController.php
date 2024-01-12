<?php

namespace App\Http\Controllers\Agent\Shift;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Utils\Datatables\Agent\Shift\ShiftTransactionDatatable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\SearchPane;

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

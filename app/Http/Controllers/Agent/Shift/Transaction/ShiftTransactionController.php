<?php

namespace App\Http\Controllers\Agent\Shift\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Utils\Datatables\Agent\Shift\ShiftTransactionDatatable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;

class ShiftTransactionController extends Controller
{
    public function __invoke(Request $request, Shift $shift, Builder $datatableBuilder, ShiftTransactionDatatable $transactionDatatable): View|JsonResponse
    {

        if ($request->ajax()) {

            return $transactionDatatable->index(shift: $shift, isToday: false);
        }

        $dataTableHtml = $transactionDatatable->columns(datatableBuilder: $datatableBuilder);

        $tills = ShiftNetwork::query()->where('shift_id', $shift->id)->where('balance_new', '>', 0)->with('network.agency')->cursor();

        $locations = Location::query()->cursor();

        return view('agent.agency.transactions', [
            'dataTableHtml' => $dataTableHtml,
            'locations' => $locations,
            'tills' => $tills,
            'shift' => $shift,
        ]);
    }
}

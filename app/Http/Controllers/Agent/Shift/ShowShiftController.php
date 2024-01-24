<?php

namespace App\Http\Controllers\Agent\Shift;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Location;
use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Utils\Datatables\Agent\Shift\ShiftLoansDatatable;
use App\Utils\Datatables\Agent\Shift\ShiftTransactionDatatable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class ShowShiftController extends Controller
{
    public function __invoke(Request $request, Shift $shift, Builder $datatableBuilder, ShiftTransactionDatatable $transactionDatatable)
    {

        if ($request->ajax()) {

           return $transactionDatatable->index($shift);

        }

        $dataTableHtml = $transactionDatatable->columns(datatableBuilder: $datatableBuilder);


        $tills = ShiftNetwork::query()->where('shift_id', $shift->id)->with('network.agency')->cursor();


        $totalBalance = $shift->cash_end ;

        $locations = Location::query()->where('code', $shift->location_code)->cursor();

        $loans = Loan::query()
            ->latest()
            ->whereBelongsTo($shift, 'shift')
            ->with('location', 'shift', 'network.agency', 'user')
            ->selectRaw('*, note')
            ->get();

        return view('agent.agency.show', [
            'dataTableHtml' => $dataTableHtml,
            'loans' => $loans,
            'locations' => $locations,
            'totalBalance' => $totalBalance,
            'tills' => $tills,
            'shift' => $shift->loadMissing('user', 'location'),
        ]);
    }
}

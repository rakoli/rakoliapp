<?php

namespace App\Http\Controllers\Agent\Shift;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Location;
use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Utils\Datatables\Agent\Shift\ShiftLoansDatatable;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;

class ShowShiftLoanController extends Controller
{
    public function __invoke(Request $request, Shift $shift, Builder $datatableBuilder, ShiftLoansDatatable $shiftLoansDatatable)
    {

        if ($request->ajax()) {

            return $shiftLoansDatatable->index($shift);

        }

        $dataTableHtml = $shiftLoansDatatable->columns(datatableBuilder: $datatableBuilder);

        $tills = ShiftNetwork::query()->where('shift_id', $shift->id)->with('network.agency')->cursor();

        $totalBalance = $shift->cash_end + $tills->sum('balance_new');

        $locations = Location::query()->where('code', $shift->location_code)->cursor();

        $loans = Loan::query()
            ->latest()
            ->whereBelongsTo($shift, 'shift')
            ->with('location', 'shift', 'network.agency', 'user')
            ->selectRaw('*, note')
            ->get();

        return view('agent.agency.loans', [
            'datatableHtml' => $dataTableHtml,
            'loans' => $loans,
            'locations' => $locations,
            'totalBalance' => $totalBalance,
            'tills' => $tills,
            'shift' => $shift->loadMissing('user', 'location'),
        ]);
    }
}

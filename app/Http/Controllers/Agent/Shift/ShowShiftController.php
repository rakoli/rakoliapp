<?php

namespace App\Http\Controllers\Agent\Shift;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Location;
use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Utils\Datatables\Agent\Shift\ShiftCashTransactionDatatable;
use App\Utils\Datatables\Agent\Shift\ShiftTransactionDatatable;
use App\Utils\Enums\NetworkTypeEnum;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;

class ShowShiftController extends Controller
{
    public function __invoke(Request $request, Shift $shift, Builder $datatableBuilder, ShiftTransactionDatatable $transactionDatatable, ShiftCashTransactionDatatable $cashTransactionDatatable)
    {
        if ($request->ajax()) {
            if($request->has('isCash')){
                return $cashTransactionDatatable->index($shift);
            } else if($request->has('isCrypto')){
                return $transactionDatatable->index($shift,NetworkTypeEnum::CRYPTO);
            } else {
                return $transactionDatatable->index($shift,NetworkTypeEnum::FINANCE);
            }
        }

        $dataTableHtml = $transactionDatatable->columns(datatableBuilder: $datatableBuilder);

        $tills = ShiftNetwork::query()->where('shift_networks.shift_id', $shift->id)->with(['network.agency','network.crypto']);

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
            ...shiftBalances(shift: $shift),
            'tills' => $tills->cursor(),
            'shift' => $shift->loadMissing('user', 'location'),
        ]);
    }

}

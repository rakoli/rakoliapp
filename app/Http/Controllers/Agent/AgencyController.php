<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Utils\Datatables\Agent\Shift\ShiftDatatable;
use App\Utils\Enums\ShiftStatusEnum;
use Yajra\DataTables\Html\Builder;

class AgencyController extends Controller
{
    public function shift(Builder $datatableBuilder, ShiftDatatable $shiftDatatable)
    {
        if (\request()->ajax()) {
            return $shiftDatatable->index();
        }

        $hasOpenShift = Shift::query()->where('status', ShiftStatusEnum::OPEN)->exists();

        $tills = Network::query()->with('agency')->cursor();

        $locations = Location::query()->cursor();

        return view('agent.agency.shift', [
            'hasOpenShift' => $hasOpenShift,
            'tills' => $tills,
            'locations' => $locations,
            'dataTableHtml' => $shiftDatatable->columns(datatableBuilder: $datatableBuilder),
        ]);
    }

    public function tills()
    {
        return view('agent.agency.shift_tills');
    }
}

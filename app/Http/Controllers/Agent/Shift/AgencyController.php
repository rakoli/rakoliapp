<?php

namespace App\Http\Controllers\Agent\Shift;

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



        return view('agent.agency.shift.index', [

            'dataTableHtml' => $shiftDatatable->columns(datatableBuilder: $datatableBuilder),
        ]);
    }

    public function tills()
    {
        return view('agent.agency.shift_tills');
    }
}

<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Models\User;
use App\Utils\Datatables\Agent\Shift\ShiftDatatable;
use App\Utils\Enums\ShiftStatusEnum;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AgencyController extends Controller
{

    public function shift()
    {
        if (\request()->ajax())
        {
            return  (new ShiftDatatable())->index();
        }

        $hasOpenShift = Shift::query()->where('status',ShiftStatusEnum::OPEN)->exists();

        $tills = Network::query()->with('agency')->cursor();

        $locations = Location::query()->cursor();
        return view('agent.agency.shift',[
            'hasOpenShift' => $hasOpenShift,
            'tills' => $tills,
            'locations' => $locations,
        ]);
    }


    public function tills()
    {
        return view('agent.agency.shift_tills');
    }




}

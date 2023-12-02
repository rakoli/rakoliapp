<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Network;
use App\Models\Shift;
use App\Models\User;
use App\Utils\Datatables\Agent\Shift\ShiftDatatable;
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

        return view('agent.agency.shift');
    }


    public function tills()
    {
        return view('agent.agency.shift_tills');
    }




}

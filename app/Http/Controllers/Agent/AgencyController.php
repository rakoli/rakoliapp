<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Network;
use App\Models\Shift;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AgencyController extends Controller
{
    public function transactions()
    {

        return view('agent.agency.transactions');
    }

    public function shift()
    {
        if (\request()->ajax())
        {
            return  DataTables::eloquent(Shift::query())->toJson();
        }



        return view('agent.agency.shift')->with([

        ]);
    }

    public function tills()
    {

        return view('agent.agency.tills');
    }

    public function networks()
    {

        return view('agent.agency.networks');
    }

    public function loans()
    {

        return view('agent.agency.loans');
    }

}

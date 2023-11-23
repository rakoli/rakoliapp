<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Network;
use App\Models\Shift;
use App\Models\User;
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
            return  DataTables::eloquent(Shift::query()->with('user'))
                ->addColumn('user_name', function (Shift $shift) {
                    return $shift->user->fullName;
                })->addColumn('created_at', function (Shift $shift) {
                    return $shift->created_at->format('Y-m-d');
                })
                ->toJson();
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

<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function transactions()
    {

        return view('agent.agency.transactions');
    }

    public function shift()
    {

        return view('agent.agency.shift');
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

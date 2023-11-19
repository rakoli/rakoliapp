<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    public function ads()
    {

        return view('agent.exchange.ads');
    }

    public function orders()
    {

        return view('agent.exchange.orders');
    }

    public function transactions()
    {

        return view('agent.exchange.transactions');
    }


    public function posts()
    {

        return view('agent.exchange.posts');
    }


    public function security()
    {

        return view('agent.exchange.security');
    }
}

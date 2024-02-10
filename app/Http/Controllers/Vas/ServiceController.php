<?php

namespace App\Http\Controllers\Vas;

use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function advertisement()
    {

        return view('vas.services.advertisement');
    }

    public function data()
    {

        return view('vas.services.data');
    }

    public function sales()
    {

        return view('vas.services.sales');
    }

    public function verification()
    {

        return view('vas.services.verification');
    }

    public function manage()
    {

        return view('vas.services.manage');
    }
}

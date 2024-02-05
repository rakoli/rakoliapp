<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BusinessController extends Controller
{
    public function listbusiness()
    {

        return view('admin.business.listbusiness');
    }

    public function listusers()
    {

        return view('admin.business.listusers');
    }
}

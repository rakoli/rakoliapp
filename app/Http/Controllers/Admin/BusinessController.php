<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

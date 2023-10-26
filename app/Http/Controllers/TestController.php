<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use RuntimeException;

class TestController extends Controller
{
    public function testing()
    {


        return view('frontend.contactus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\SystemIncome;
use Illuminate\Http\Request;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use RuntimeException;

class TestController extends Controller
{
    public function testing()
    {

        dd(SystemIncome::with('country')->
        orderBy('id','desc')
            ->take(10)->get());

        return view('frontend.contactus');
    }
}

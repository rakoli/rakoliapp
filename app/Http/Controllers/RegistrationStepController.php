<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrationStepController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']); //Confirm it is a loggedin user
    }

    public function registrationAgent()
    {
        $step = auth()->user()->registration_step;

        return view('auth.registration_agent.index', compact('step'));
    }

    public function registrationVas()
    {
        $step = auth()->user()->registration_step;

        return view('auth.registration_vas.index');
    }
}

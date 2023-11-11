<?php

namespace App\Http\Controllers;

use App\Actions\RequestEmailVerificationCode;
use App\Utils\VerifyOTP;
use Carbon\Carbon;
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

    public function requestEmailCodeAjax(Request $request)
    {
        $user = $request->user();
        if(VerifyOTP::hasActiveEmailOTP($user)){
            return [
                'status' => 201,
                'message' => 'Email already sent try again in '. Carbon::create($user->email_otp_time)->addSeconds(VerifyOTP::$validtime)->diffForHumans()
            ];
        }

        if (VerifyOTP::shouldLockEmailOTP($user)) {
            return [
                'status' => 201,
                'message' => 'Account locked! Reached trial limit'
            ];
        }

        $result = RequestEmailVerificationCode::dispatch($request->user());

        return [
            'status' => 200,
            'message' => 'successful'
        ];
    }

    public function registrationVas()
    {
        $step = auth()->user()->registration_step;

        return view('auth.registration_vas.index');
    }
}

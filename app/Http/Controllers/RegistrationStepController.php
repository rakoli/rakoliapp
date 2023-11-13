<?php

namespace App\Http\Controllers;

use App\Actions\RequestEmailVerificationCode;
use App\Actions\RequestPhoneVerificationCode;
use App\Models\Business;
use App\Models\User;
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

        if($user->email_verified_at != null){
            return [
                'status' => 200,
                'message' => 'Email already verified'
            ];
        }

        if(VerifyOTP::hasActiveEmailOTP($user)){
            return [
                'status' => 201,
                'message' => __('Email already sent try again in '). Carbon::create($user->email_otp_time)->addSeconds(VerifyOTP::$validtime)->diffForHumans()
            ];
        }

        if (VerifyOTP::shouldLockEmailOTP($user)) {
            return [
                'status' => 201,
                'message' => __('Account locked! Reached trial limit')
            ];
        }

        RequestEmailVerificationCode::dispatch($request->user());

        return [
            'status' => 200,
            'message' => 'successful'
        ];
    }

    public function verifyEmailCodeAjax(Request $request)
    {
        $user = $request->user();

        if($user->email_verified_at != null){
            return [
                'status' => 200,
                'message' => 'Email already verified'
            ];
        }

        $request->validate([
            'email_code' => 'required|numeric',
        ]);

        if(VerifyOTP::isEmailOTPValid($request->get('email_code'),$user)){

            $user->email_verified_at = now();
            $user->email_otp = null;
            $user->email_otp_time = null;
            $user->email_otp_count = null;

            if($user->phone_verified_at != null){
                $user->registration_step = $user->registration_step + 1;
            }

            $user->save();

            return [
                'status' => 200,
                'message' => 'valid'
            ];
        }


        return [
            'status' => 201,
            'message' => 'invalid'
        ];
    }

    public function registrationVas()
    {
        $step = auth()->user()->registration_step;

        return view('auth.registration_vas.index');
    }

    public function requestPhoneCodeAjax(Request $request)
    {
        $user = $request->user();

        if($user->phone_verified_at != null){
            return [
                'status' => 200,
                'message' => 'Phone already verified'
            ];
        }

        if(VerifyOTP::hasActivePhoneOTP($user)){
            return [
                'status' => 201,
                'message' => __('SMS already sent try again in '). Carbon::create($user->phone_otp_time)->addSeconds(VerifyOTP::$validtime)->diffForHumans()
            ];
        }

        if (VerifyOTP::shouldLockPhoneOTP($user)) {
            return [
                'status' => 201,
                'message' => __('Account locked! Reached trial limit')
            ];
        }

        RequestPhoneVerificationCode::dispatch($request->user());

        return [
            'status' => 200,
            'message' => 'successful'
        ];
    }

    public function verifyPhoneCodeAjax(Request $request)
    {
        $user = $request->user();

        if($user->phone_verified_at != null){
            return [
                'status' => 200,
                'message' => 'Phone already verified'
            ];
        }

        $request->validate([
            'phone_code' => 'required|numeric',
        ]);

        if(VerifyOTP::isPhoneOTPValid($request->get('phone_code'),$user)){

            $user->phone_verified_at = now();
            $user->phone_otp = null;
            $user->phone_otp_time = null;
            $user->phone_otp_count = null;

            if($user->email_verified_at != null){
                $user->registration_step = $user->registration_step + 1;
            }

            $user->save();

            return [
                'status' => 200,
                'message' => 'valid'
            ];
        }

        return [
            'status' => 201,
            'message' => 'invalid'
        ];
    }

    public function editContactInformation(Request $request)
    {
        $request->validate([
            'email' => 'sometimes|email',
            'phone' => 'sometimes|numeric',
        ]);

        $user = $request->user();
        $requestEmail = $request->get('email');
        $requestPhone = $request->get('phone');

        $emailExist = User::where('email',$requestEmail)->where('id', '!=', $user->id)->first();

        if($user->email_verified_at === null && $user->email != $requestEmail){
            if($emailExist === null && $requestEmail != null ){
                $user->email = $requestEmail;
            }
        }

        if($user->phone_verified_at === null && $user->phone != $requestPhone){
            if($requestPhone != null ){
                $user->phone = $requestPhone;
            }
        }

        if($emailExist != null){
            return redirect()->back()->withErrors([__("Email already exist")]);
        }

        $user->save();

        return redirect()->back();

    }

    public function registrationStepConfirmation(Request $request)
    {
        $request->validate([
            'next_step' => 'required|numeric|min:1',
        ]);

        $nextStep = $request->get('next_step');
        $currentRegistrationStep = $request->user()->registration_step;

        if($currentRegistrationStep < $nextStep){
            return [
                'status' => 201,
                'message' => __('Complete current step before proceeding')
            ];
        }

        return [
            'status' => 200,
            'message' => 'continue'
        ];
    }

    public function updateBusinessDetails(Request $request)
    {
        $user = $request->user();

        if($user->business_code != null){
            return [
                'status' => 200,
                'message' => 'business details already updated'
            ];
        }

        $request->validate([
            'business_name' => 'required|string',
            'reg_id' => 'sometimes|string|nullable',
            'tax_id' => 'sometimes|string|nullable',
            'reg_date' => 'sometimes|date|nullable',
        ]);

        $regDate = $request->get('reg_date',null);
        if($regDate != null){
            $regDate = Carbon::create($regDate);
        }

        $response = Business::addBusiness([
                'country_code' => $user->country_code,
                'code' => generateCode($request->get('business_name'),$user->country_code),
                'type' => $user->type,
                'business_name' => $request->get('business_name'),
                'business_regno' => $request->get('reg_id',null),
                'tax_id' => $request->get('tax_id',null),
                'business_reg_date' => $regDate,
            ]);

        if($response === false){
            return [
                'status' => 201,
                'message' => "Failed to Update Business. Try again!"
            ];
        }

        $user->business_code = $response->code;
        $user->registration_step = $user->registration_step + 1;
        $user->save();

        return [
            'status' => 200,
            'message' => 'updated'
        ];
    }
}

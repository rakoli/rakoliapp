<?php

namespace App\Http\Controllers;

use App\Actions\CheckUserPendingSystemPayments;
use App\Actions\GenerateDPOPayment;
use App\Actions\InitiateSubscriptionPayment;
use App\Actions\RequestEmailVerificationCode;
use App\Actions\RequestPhoneVerificationCode;
use App\Actions\SendTelegramNotification;
use App\Models\Business;
use App\Models\InitiatedPayment;
use App\Models\Package;
use App\Models\User;
use App\Utils\DPORequestTokenFormat;
use App\Utils\Enums\InitiatedPaymentStatusEnum;
use App\Utils\VerifyOTP;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegistrationStepController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']); //Confirm it is a loggedin user
    }

    public function registrationAgent()
    {
        $step = auth()->user()->registration_step;
        if($step == 0){
            return redirect()->route('home');
        }
        $hasPendingPayment = false;

        $initiatedPayments = auth()->user()->getBusinessPendingPayments();

        if(!$initiatedPayments->isEmpty()){
            $hasPendingPayment = true;
            CheckUserPendingSystemPayments::run(auth()->user(),$initiatedPayments);
            //To redirect to next registration step
            if(!auth()->user()->hasPendingPayment()){
                $step = User::where('code',auth()->user()->code)->first()->registration_step;
            }
        }
        return view('auth.registration_agent.index', compact('step','hasPendingPayment','initiatedPayments'));
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
        $user = $request->user();

        if($currentRegistrationStep == 1){
            if($user->email_verified_at != null && $user->phone_verified_at != null){
                $user->registration_step = $user->registration_step + 1;
                $user->save();
                $currentRegistrationStep = $currentRegistrationStep + 1;
            }
        }elseif($currentRegistrationStep == 2){
            if($user->business_code != null){
                $user->registration_step = $user->registration_step + 1;
                $user->save();
                $currentRegistrationStep = $currentRegistrationStep + 1;
            }
        }elseif($currentRegistrationStep == 3){
            if($user->business->package_code != null){
                $user->registration_step = $user->registration_step + 1;
                $user->save();
                $currentRegistrationStep = $currentRegistrationStep + 1;
            }
        }elseif($currentRegistrationStep == 4 && $nextStep == 5){
            $user->registration_step = 0;
            $user->save();

            setupSession($user);//Updating User session

            if(env('APP_ENV') == 'production'){
                $message = "Registration Complete: $user->fname $user->lname ({$user->business->business_name}) has completed registration with {$user->business->package->name}.";
                SendTelegramNotification::dispatch($message);
            }

            return [
                'status' => 200,
                'message' => __('Complete')
            ];
        }

        if($currentRegistrationStep < $nextStep ){
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
            'message' => 'updated',
            'business' => $response
        ];
    }

    public function paySubscription(Request $request)
    {
        $user = $request->user();
        $testingMethod = "";
        if(env("APP_ENV") != "production"){
            $testingMethod = ',test';
        }

        $request->validate([
            'selected_plan_code' => 'required|exists:packages,code',
            'payment_method' => 'required|in:'.implode(',', config('payments.accepted_payment_methods')).$testingMethod,
        ]);

        $package = Package::where('code',$request->get('selected_plan_code'))->first();
        $paymentMethod = $request->get('payment_method');

        $similarPendingPayment = InitiatedPayment::where('business_code',$user->business_code)
            ->where('expiry_time','>',now())
            ->where('channel',$paymentMethod)
            ->where('description',$package->code)
            ->where('status',InitiatedPaymentStatusEnum::INITIATED)->get();

        if(!$similarPendingPayment->isEmpty()){
            return redirect()->back()->withErrors([__('Duplicate request! Pay existing pending payment')]);
        }

        $requestResult = InitiateSubscriptionPayment::run($paymentMethod,$user,$package);

        if($requestResult['success'] == false){
            return redirect()->back()->withErrors([$requestResult['resultExplanation']]);
        }

        return redirect($requestResult['url']);
    }

    public function registrationVas()
    {
        $step = auth()->user()->registration_step;
        if($step == 0){
            return redirect()->route('home');
        }
        return view('auth.registration_vas.index', compact('step'));
    }
}

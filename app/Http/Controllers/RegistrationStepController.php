<?php

namespace App\Http\Controllers;

use App\Actions\CheckUserPendingSystemPayments;
use App\Actions\GenerateDPOPayment;
use App\Actions\InitiateSubscriptionPayment;
use App\Actions\RequestEmailVerificationCode;
use App\Actions\RequestPhoneVerificationCode;
use App\Actions\SendTelegramNotification;
use App\Mail\WelcomeMail;
use App\Models\Business;
use App\Models\InitiatedPayment;
use App\Models\Package;
use App\Models\User;
use App\Utils\SMS;
use App\Utils\VerifyOTP;
use App\Utils\DynamicResponse;
use App\Utils\Enums\InitiatedPaymentStatusEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RegistrationStepController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']); //Confirm it is a loggedin user
    }

    public function registrationAgent()
    {
        $user = auth()->user();
        $step = $user->registration_step;

        if($step == 0){
            return redirect()->route('home');
        }

        // Check if phone verification is required before proceeding
        if (is_null($user->phone_verified_at)) {
            return redirect()->route('registration.phone.verify');
        }

        $hasPendingPayment = false;

        $initiatedPayments = $user->getBusinessPendingPayments();

        if(!$initiatedPayments->isEmpty()){
            $hasPendingPayment = true;
            CheckUserPendingSystemPayments::run($user,$initiatedPayments);
            //To redirect to next registration step
            if(!$user->hasPendingPayment()){
                $step = User::where('code',$user->code)->first()->registration_step;
            }
        }
        return view('auth.registration_agent.index', compact('step','hasPendingPayment','initiatedPayments'));
    }

    /**
     * Format phone number for display
     */
    private function formatPhoneForDisplay($phone, $countryCode)
    {
        // Phone is already stored with dialing code (e.g., 255693338637)
        // Just add the + sign for display
        return "+{$phone}";
    }

    /**
     * Generate and send OTP directly using SMS utility
     */
    private function generateAndSendOTP(User $user)
    {
        if (VerifyOTP::shouldLockPhoneOTP($user)) {
            return false;
        }

        $otp = VerifyOTP::generateOTPCode();
        $minutes = (VerifyOTP::$validtime / 60);
        $text = env('APP_NAME').' verification code: '.$otp."\nValid for ".$minutes.' min.';

        SMS::sendToUser($user, $text);

        Log::channel('agent_registration')->info("Direct SMS sent to: {$user->phone} with OTP: {$otp}");

        // Save OTP to user
        $user->phone_otp = $otp;
        $user->phone_otp_time = now();
        $user->phone_otp_count = $user->phone_otp_count + 1;
        $user->save();

        return true;
    }

    public function showPhoneVerification()
    {
        $user = auth()->user();

        // If phone is already verified, redirect to registration agent
        if (!is_null($user->phone_verified_at)) {
            return redirect()->route('registration.agent');
        }

        // Debug: Log the phone data
        Log::channel('agent_registration')->info("Debug - Raw phone: {$user->phone}, Country code: {$user->country_code}");

        // Send OTP automatically if no active OTP exists
        if (!VerifyOTP::hasActivePhoneOTP($user) && !VerifyOTP::shouldLockPhoneOTP($user)) {
            $this->generateAndSendOTP($user);
            Log::channel('agent_registration')->info("RegistrationStepController :: showPhoneVerification :: Direct OTP sent to phone: ".$user->phone);
            session()->flash('otp_sent_recently', true);
        }

        // Format phone number for display
        $formattedPhone = $this->formatPhoneForDisplay($user->phone, $user->country_code);

        Log::channel('agent_registration')->info("Debug - Formatted phone: {$formattedPhone}");

        return view('auth.phone_verification', compact('user', 'formattedPhone'));
    }

    public function verifyPhoneOtp(Request $request)
    {
        $request->validate([
            'phone_code' => 'required|numeric',
        ]);

        $user = $request->user();

        // If already verified, redirect
        if (!is_null($user->phone_verified_at)) {
            return redirect()->route('registration.agent');
        }

        if (VerifyOTP::isPhoneOTPValid($request->get('phone_code'), $user)) {
            $user->phone_verified_at = now();
            $user->phone_otp = null;
            $user->phone_otp_time = null;
            $user->phone_otp_count = null;
            $user->save();

            Log::channel('agent_registration')->info("RegistrationStepController :: verifyPhoneOtp :: Phone verified successfully: ".$user->phone);

            return redirect()->route('registration.agent')->with('success', 'Phone verified successfully!');
        }

        Log::channel('agent_registration')->info("RegistrationStepController :: verifyPhoneOtp :: Invalid OTP for phone: ".$user->phone);

        return redirect()->back()->withErrors(['phone_code' => 'Invalid or expired verification code. Please try again.']);
    }

    public function resendPhoneOtp(Request $request)
    {
        $user = $request->user();

        if (!is_null($user->phone_verified_at)) {
            return response()->json([
                'status' => 200,
                'message' => 'Phone already verified'
            ]);
        }

        if (VerifyOTP::hasActivePhoneOTP($user)) {
            return response()->json([
                'status' => 201,
                'message' => __('SMS already sent, try again in ') . Carbon::create($user->phone_otp_time)->addSeconds(VerifyOTP::$validtime)->diffForHumans()
            ]);
        }

        if (VerifyOTP::shouldLockPhoneOTP($user)) {
            return response()->json([
                'status' => 201,
                'message' => __('Account locked! Reached trial limit')
            ]);
        }

        $this->generateAndSendOTP($user);
        Log::channel('agent_registration')->info("RegistrationStepController :: resendPhoneOtp :: Direct OTP resent to phone: ".$user->phone);

        return response()->json([
            'status' => 200,
            'message' => 'OTP sent successfully!'
        ]);
    }

    public function updatePhoneNumber(Request $request)
    {
        $user = $request->user();

        // If phone is already verified, don't allow changes
        if (!is_null($user->phone_verified_at)) {
            return response()->json([
                'status' => 201,
                'message' => 'Phone already verified. Cannot update.'
            ]);
        }

        $request->validate([
            'phone' => 'required|numeric|min:8',
            'country_code' => 'required|string|exists:countries,code',
        ]);

        $requestPhone = $request->get('phone');
        $countryCode = $request->get('country_code');

        // Get country dial code
        $country = \App\Models\Country::where('code', $countryCode)->first();
        if (!$country) {
            return response()->json([
                'status' => 201,
                'message' => 'Invalid country code'
            ]);
        }

        // Format phone number (remove leading 0 if present, add country code without +)
        $plainPhone = ltrim($requestPhone, '0');
        $countryDialCode = substr($country->dialing_code, 1); // Remove the + sign
        $fullPhone = $countryDialCode . $plainPhone;

        // Check if phone number already exists for another user
        $phoneExists = User::where('phone', $fullPhone)
            ->where('id', '!=', $user->id)
            ->exists();

        if ($phoneExists) {
            return response()->json([
                'status' => 201,
                'message' => __('Phone number already registered to another account')
            ]);
        }

        // Update user's phone number and reset OTP data
        $user->phone = $fullPhone;
        $user->country_code = $countryCode;
        $user->phone_otp = null;
        $user->phone_otp_time = null;
        $user->phone_otp_count = 0;
        $user->save();

        Log::channel('agent_registration')->info("RegistrationStepController :: updatePhoneNumber :: Phone updated to: ".$fullPhone);

        // Send OTP to new phone number
        if (!VerifyOTP::shouldLockPhoneOTP($user)) {
            $this->generateAndSendOTP($user);
            Log::channel('agent_registration')->info("RegistrationStepController :: updatePhoneNumber :: OTP sent to new phone");
        }

        return response()->json([
            'status' => 200,
            'message' => 'Phone number updated successfully. New OTP sent.',
            'formatted_phone' => $this->formatPhoneForDisplay($fullPhone, $countryCode)
        ]);
    }

    public function requestEmailCodeAjax(Request $request)
    {
        Log::channel('agent_registration')->info("RegistrationStepController :: requestEmailCodeAjax :: Start Email Verification");

        $user = $request->user();

        Log::channel('agent_registration')->info("RegistrationStepController :: requestEmailCodeAjax :: User Email Verification :: ".$user->email);

        if($user->email_verified_at != null){
            Log::channel('agent_registration')->info("RegistrationStepController :: requestEmailCodeAjax :: Email already Verification at :: ".$user->email_verified_at);
            return [
                'status' => 200,
                'message' => 'Email already verified'
            ];
        }

        if(VerifyOTP::hasActiveEmailOTP($user)){
            Log::channel('agent_registration')->info("RegistrationStepController :: requestEmailCodeAjax :: Email otp isn't expired.");
            return [
                'status' => 201,
                'message' => __('Email already sent try again in '). Carbon::create($user->email_otp_time)->addSeconds(VerifyOTP::$validtime)->diffForHumans()
            ];
        }

        if (VerifyOTP::shouldLockEmailOTP($user)) {
            Log::channel('agent_registration')->info("RegistrationStepController :: requestEmailCodeAjax :: Account locked due to multiple try.");
            return [
                'status' => 201,
                'message' => __('Account locked! Reached trial limit')
            ];
        }

        RequestEmailVerificationCode::dispatch($request->user());

        Log::channel('agent_registration')->info("RegistrationStepController :: requestEmailCodeAjax :: Otp sent in email.");

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

            // if($user->phone_verified_at != null){
            //     $user->registration_step = $user->registration_step + 1;
            // }

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
        Log::channel('agent_registration')->info("RegistrationStepController :: requestPhoneCodeAjax :: Start Phone Verification");

        $user = $request->user();

        Log::channel('agent_registration')->info("RegistrationStepController :: requestPhoneCodeAjax :: User Email Verification :: ".$user->phone);

        if($user->phone_verified_at != null){
            Log::channel('agent_registration')->info("RegistrationStepController :: requestPhoneCodeAjax :: Email already Verification at :: ".$user->phone_verified_at);
            return [
                'status' => 200,
                'message' => 'Phone already verified'
            ];
        }

        if(VerifyOTP::hasActivePhoneOTP($user)){
            Log::channel('agent_registration')->info("RegistrationStepController :: requestPhoneCodeAjax :: Phone otp isn't expired.");
            return [
                'status' => 201,
                'message' => __('SMS already sent try again in '). Carbon::create($user->phone_otp_time)->addSeconds(VerifyOTP::$validtime)->diffForHumans()
            ];
        }

        if (VerifyOTP::shouldLockPhoneOTP($user)) {
            Log::channel('agent_registration')->info("RegistrationStepController :: requestPhoneCodeAjax :: Account locked due to multiple try.");
            return [
                'status' => 201,
                'message' => __('Account locked! Reached trial limit')
            ];
        }

        RequestPhoneVerificationCode::dispatch($request->user());
        Log::channel('agent_registration')->info("RegistrationStepController :: requestPhoneCodeAjax :: Otp sent on phone.");

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

            // if($user->email_verified_at != null){
            //     $user->registration_step = $user->registration_step + 1;
            // }

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
            return DynamicResponse::sendResponse(function() {
                return redirect()->back()->withErrors([__("Email already exist")]);
            },function() {
                return responder()->error('email_exists',__("Email already exist"));
            });
        }

        $user->save();

        return DynamicResponse::sendResponse(function() {
            return redirect()->back();
        },function() {
            return responder()->success(['message' => 'contact details edited']);
        });
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
            $user->isowner = 1;
            $user->save();

            if(!$request->is('api/*')) {
                setupSession($user);//Updating User session
            }

            if(env('APP_ENV') == 'production'){
                $message = "Registration Complete: $user->fname $user->lname ({$user->business->business_name}) has
                completed registration with ". strtoupper($user->business->package->name)." package for
                {$user->business->package->price} {$user->business->package->price_currency}).";
                SendTelegramNotification::dispatch($message);
            }

            Mail::to($user->email)->send(new WelcomeMail($user));

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

        $addBusinessData = [
            'country_code' => $user->country_code,
            'code' => generateCode($request->get('business_name'),$user->country_code),
            'type' => $user->type,
            'business_name' => $request->get('business_name'),
            'business_regno' => $request->get('reg_id',null),
            //'tax_id' => $request->get('tax_id',null),
            'business_reg_date' => $regDate,
        ];

        if($user->referral_business_code != null){
            $addBusinessData['referral_business_code'] = $user->referral_business_code;
        }

        $response = Business::addBusiness($addBusinessData,$user);

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
            return DynamicResponse::sendResponse(function() {
                return redirect()->back()->withErrors([__('Duplicate request! Pay existing pending payment')]);
            },function() {
                return responder()->error('duplicate_payment','Duplicate request! Pay existing pending payment');
            });
        }

        $requestResult = InitiateSubscriptionPayment::run($paymentMethod,$user,$package,$request->is_trial);

        if($requestResult['success'] == false){
            return DynamicResponse::sendResponse(function() use ($requestResult) {
                return redirect()->back()->withErrors([$requestResult['resultExplanation']]);
            },function() use ($requestResult) {
                return responder()->error('payment_request_failed',$requestResult['resultExplanation']);
            });
        }

        return DynamicResponse::sendResponse(function() use ($requestResult){
            return redirect($requestResult['url']);
        },function() use ($requestResult) {
            return responder()->success(['message' => 'payment request initiated','paymentUrl'=>$requestResult['url']]);
        });
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

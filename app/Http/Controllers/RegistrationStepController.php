<?php

namespace App\Http\Controllers;

use App\Actions\CheckUserPendingSystemPayments;
use App\Actions\GenerateDPOPayment;
use App\Actions\InitiateSubscriptionPayment;
use App\Actions\RequestEmailVerificationCode;
use App\Actions\RequestPhoneVerificationCode;
use App\Actions\Vas\Registration\DocumentUploads;
use App\Events\RegistrationCompletedEvent;
use App\Actions\SendTelegramNotification;
use App\Models\Business;
use App\Models\BusinessVerificationUpload;
use App\Models\Package;
use App\Models\User;
use App\Utils\DPORequestTokenFormat;
use App\Utils\Enums\BusinessUploadDocumentTypeEnums;
use App\Utils\VerifyOTP;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RegistrationStepController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']); //Confirm it is a loggedin user
    }

    public function registrationAgent()
    {
        $step = auth()->user()->registration_step;
        if ($step == 0) {
            return redirect()->route('home');
        }
        $hasPendingPayment = false;

        $initiatedPayments = auth()->user()->getBusinessPendingPayments();

        if (!$initiatedPayments->isEmpty()) {
            $hasPendingPayment = true;
            CheckUserPendingSystemPayments::run(auth()->user(), $initiatedPayments);
            //To redirect to next registration step
            if (!auth()->user()->hasPendingPayment()) {
                $step = User::where('code', auth()->user()->code)->first()->registration_step;
            }
        }
        return view('auth.registration_agent.index', compact('step', 'hasPendingPayment'));
    }

    public function requestEmailCodeAjax(Request $request)
    {
        $user = $request->user();

        if ($user->email_verified_at != null) {
            return [
                'status' => 200,
                'message' => 'Email already verified'
            ];
        }

        if (VerifyOTP::hasActiveEmailOTP($user)) {
            return [
                'status' => 201,
                'message' => __('Email already sent try again in ') . Carbon::create($user->email_otp_time)->addSeconds(VerifyOTP::$validtime)->diffForHumans()
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

        if ($user->email_verified_at != null) {
            return [
                'status' => 200,
                'message' => 'Email already verified'
            ];
        }

        $request->validate([
            'email_code' => 'required|numeric',
        ]);

        if (VerifyOTP::isEmailOTPValid($request->get('email_code'), $user)) {

            $user->email_verified_at = now();
            $user->email_otp = null;
            $user->email_otp_time = null;
            $user->email_otp_count = null;

            if ($user->phone_verified_at != null) {
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

        if ($user->phone_verified_at != null) {
            return [
                'status' => 200,
                'message' => 'Phone already verified'
            ];
        }

        if (VerifyOTP::hasActivePhoneOTP($user)) {
            return [
                'status' => 201,
                'message' => __('SMS already sent try again in ') . Carbon::create($user->phone_otp_time)->addSeconds(VerifyOTP::$validtime)->diffForHumans()
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

        if ($user->phone_verified_at != null) {
            return [
                'status' => 200,
                'message' => 'Phone already verified'
            ];
        }

        $request->validate([
            'phone_code' => 'required|numeric',
        ]);

        if (VerifyOTP::isPhoneOTPValid($request->get('phone_code'), $user)) {

            $user->phone_verified_at = now();
            $user->phone_otp = null;
            $user->phone_otp_time = null;
            $user->phone_otp_count = null;

            if ($user->email_verified_at != null) {
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

        $emailExist = User::where('email', $requestEmail)->where('id', '!=', $user->id)->first();

        if ($user->email_verified_at === null && $user->email != $requestEmail) {
            if ($emailExist === null && $requestEmail != null) {
                $user->email = $requestEmail;
            }
        }

        if ($user->phone_verified_at === null && $user->phone != $requestPhone) {
            if ($requestPhone != null) {
                $user->phone = $requestPhone;
            }
        }

        if ($emailExist != null) {
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

        if ($currentRegistrationStep == 4 && $nextStep == 5) {
            $user = $request->user();
            $user->registration_step = 0;
            $user->save();

            $message = "Registration Complete: $user->fname $user->lname ({$user->business->business_name}) has completed registration.";
            SendTelegramNotification::dispatch($message);

            return [
                'status' => 200,
                'message' => __('Complete')
            ];
        }

        if ($currentRegistrationStep < $nextStep) {
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

        if ($user->business_code != null) {
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

        $regDate = $request->get('reg_date', null);
        if ($regDate != null) {
            $regDate = Carbon::create($regDate);
        }

        $response = Business::addBusiness([
            'country_code' => $user->country_code,
            'code' => generateCode($request->get('business_name'), $user->country_code),
            'type' => $user->type,
            'business_name' => $request->get('business_name'),
            'business_regno' => $request->get('reg_id', null),
            'tax_id' => $request->get('tax_id', null),
            'business_reg_date' => $regDate,
        ]);

        if ($response === false) {
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

    public function paySubscription(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'selected_plan_code' => 'required|exists:packages,code',
            'payment_method' => 'required|in:' . implode(',', config('dpo-laravel.accepted_payment_methods')),
        ]);

        $package = Package::where('code', $request->get('selected_plan_code'))->first();

        $paymentMethod = $request->get('payment_method');

        $requestResult = InitiateSubscriptionPayment::run($paymentMethod, $user, $package);

        if ($requestResult['success'] == false) {
            return redirect()->back()->withErrors([$requestResult['resultExplanation']]);
        }

        return redirect($requestResult['result']);
    }


    public function registrationUploads(Request $request)
    {
        /** @var Business $business */

        $business = auth()->user()->business;

        $file = $request->file($request->document_name);


        $path = $file->store("uploads/business_verification/{$business->code}",'s3');

        $url = Storage::disk('s3')->url($path);

        DocumentUploads::run(
            business: $business,
            documentPath: $url,
            documentName: $request->document_name,
            documentType: BusinessUploadDocumentTypeEnums::tryFrom($request->document_type),
            updateColumns: [
                $request->column_name => $request->column_value
            ],

        );

        return response()->json(['url' => $url], 200);


    }

    public function registrationFinish(Request $request)
    {
        try {

            /** @var Business $business */
            $business = auth()->user()->business;

            if (!filled($business->tax_id)) {
                throw new \Exception("Business Tax Id is Required");
            }
            if (!filled($business->business_regno)) {
                throw new \Exception("Business Registration No is Required");
            }
            if (!BusinessVerificationUpload::query()->where(['document_type' => BusinessUploadDocumentTypeEnums::TAX_ID->value])->exists()) {

                throw new \Exception("Kindly upload your tax certificate Document");
            }

            if (!BusinessVerificationUpload::query()->where(['document_type' => BusinessUploadDocumentTypeEnums::REGISTRATION->value])->exists()) {

                throw new \Exception("Kindly upload your business Registration certificate Document");
            }

            if (!BusinessVerificationUpload::query()->where(['document_type' => BusinessUploadDocumentTypeEnums::NAT->value])->exists()) {

                throw new \Exception("Kindly upload your Identification Document");
            }


            /** @var User $user */

            $user = auth()->user();
            $user->registration_step = $user->registration_step + 1;
            $user->save();

            return [
                'status' => 200,
                'message' => 'updated'
            ];

        } catch (\Exception $e) {
            return [
                'status' => 422,
                'message' => $e->getMessage()
            ];
        }
    }

    public function registrationVas()
    {

        $step = auth()->user()->registration_step;

        if ($step == 0) {
            return redirect()->route('home');
        }
        return view('auth.registration_vas.index', compact('step'));
    }
}

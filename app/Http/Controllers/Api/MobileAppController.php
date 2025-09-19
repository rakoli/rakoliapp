<?php

namespace App\Http\Controllers\Api;

use App\Actions\CheckUserPendingSystemPayments;
use App\Models\Package;
use App\Models\User;
use App\Utils\ValidationRule;
use App\Utils\SMS;
use App\Utils\VerifyOTP;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MobileAppController
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (\Auth::attempt($credentials)) {
            $user = \Auth::user();

            if (!$user->canAccessMobileApp()) {
                return responder()->error('unauthorized');
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return responder()->success([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => getApiSessionData($user)
            ]);

        } else {
            return responder()->error('unauthorized');
        }
    }

    public function logout(Request $request)
    {

        if (!$request->user()->currentAccessToken()->delete()) {
            return responder()->error('action_failed');
        }

        return responder()->success(['message' => 'logged out successfully']);
    }

    public function register(Request $request)
    {
        try {
            $request->validate(ValidationRule::agentRegistration());

            event(new Registered($user = User::addUser($request->all())));

            // Send OTP immediately after registration
            $otpSent = $this->generateAndSendOTP($user);

            if (!$otpSent) {
                Log::error('Failed to send OTP after registration', ['user_id' => $user->id]);
                return responder()->error('otp_send_failed', 'Registration successful but failed to send OTP. Please request a new one.', [
                    'user_id' => $user->id,
                    'phone' => $this->maskPhone($user->phone)
                ]);
            }

            Log::channel('mobile_api')->info("User registered and OTP sent: {$user->phone}");

            return responder()->success([
                'message' => 'Registration successful. OTP sent to your phone for verification.',
                'user_id' => $user->id,
                'phone' => $this->maskPhone($user->phone),
                'requires_verification' => true
            ]);

        } catch (\Exception $e) {
            Log::error('Mobile registration failed: ' . $e->getMessage(), [
                'request_data' => $request->except(['password'])
            ]);
            return responder()->error('registration_failed');
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'otp' => 'required|numeric|digits:6',
            ]);

            $user = User::findOrFail($request->user_id);

            // Check if already verified
            if (!is_null($user->phone_verified_at)) {
                return responder()->success([
                    'message' => 'Phone already verified',
                    'already_verified' => true
                ]);
            }

            // Verify OTP
            if (VerifyOTP::isPhoneOTPValid($request->otp, $user)) {
                $user->phone_verified_at = now();
                $user->phone_otp = null;
                $user->phone_otp_time = null;
                $user->phone_otp_count = null;
                $user->save();

                // Complete registration and generate token
                $token = $user->createToken('auth_token')->plainTextToken;
                User::completedRegistration($user);

                Log::channel('mobile_api')->info("OTP verified successfully: {$user->phone}");

                return responder()->success([
                    'message' => 'Phone verified successfully',
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'user' => getApiSessionData($user, true)
                ]);
            }

            Log::channel('mobile_api')->info("Invalid OTP attempt: {$user->phone}");
            return responder()->error('invalid_otp', 'Invalid or expired OTP');

        } catch (\Exception $e) {
            Log::error('OTP verification failed: ' . $e->getMessage());
            return responder()->error('verification_failed');
        }
    }

    public function resendOtp(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            $user = User::findOrFail($request->user_id);

            // Check if already verified
            if (!is_null($user->phone_verified_at)) {
                return responder()->success([
                    'message' => 'Phone already verified',
                    'already_verified' => true
                ]);
            }

            // Check if OTP is still active
            if (VerifyOTP::hasActivePhoneOTP($user)) {
                $remainingTime = VerifyOTP::phoneOTPTimeRemaining($user);
                return responder()->error('otp_still_active', "OTP already sent. Try again in {$remainingTime} seconds.", [
                    'remaining_time' => $remainingTime
                ]);
            }

            // Check if user is locked
            if (VerifyOTP::shouldLockPhoneOTP($user)) {
                return responder()->error('otp_locked', 'Too many attempts. Account temporarily locked.');
            }

            // Send new OTP
            $otpSent = $this->generateAndSendOTP($user);

            if (!$otpSent) {
                return responder()->error('otp_send_failed', 'Failed to send OTP. Please try again.');
            }

            Log::channel('mobile_api')->info("OTP resent: {$user->phone}");

            return responder()->success([
                'message' => 'OTP sent successfully',
                'phone' => $this->maskPhone($user->phone)
            ]);

        } catch (\Exception $e) {
            Log::error('OTP resend failed: ' . $e->getMessage());
            return responder()->error('resend_failed');
        }
    }

    public function registrationStepStatus(Request $request)
    {
        $user = $request->user();

        $step = User::where('code',$user->code)->first()->registration_step;

        return responder()->success([
            'registrationStep' => $step
        ]);

    }

    public function subscriptionDetails(Request $request)
    {
        $user = $request->user();
        $step = User::where('code',$user->code)->first()->registration_step;

        $packages = Package::where('country_code', $user->country_code)->with(['features'])->get(['id','country_code','code','name','description','price','price_currency','package_interval_days'])->toArray();

        $hasPendingPayment = false;
        $initiatedPayments = $user->getBusinessPendingPayments();
        if(!$initiatedPayments->isEmpty()){
            $hasPendingPayment = true;
            CheckUserPendingSystemPayments::run($user,$initiatedPayments);
        }

        $paymentMethods = config('payments.accepted_payment_methods');

        if(env("APP_ENV") != "production"){
            array_push($paymentMethods,'test');
        }

        return responder()->success([
            'registrationStep' => $step,
            'hasPendingPayments' => $hasPendingPayment,
            'paymentMethods' => $paymentMethods,
            'pendingPayments' => $initiatedPayments,
            'availablePackages' => $packages
        ]);
    }

    /**
     * Generate and send OTP (reusing logic from RegistrationStepController)
     */
    private function generateAndSendOTP(User $user)
    {
        if (VerifyOTP::shouldLockPhoneOTP($user)) {
            return false;
        }

        $otp = VerifyOTP::generateOTPCode();
        $minutes = (VerifyOTP::$validtime / 60);
        $text = env('APP_NAME') . ' verification code: ' . $otp . "\nValid for " . $minutes . ' min.';

        SMS::sendToUser($user, $text);

        Log::channel('mobile_api')->info("OTP sent to: {$user->phone} with code: {$otp}");

        // Save OTP to user
        $user->phone_otp = $otp;
        $user->phone_otp_time = now();
        $user->phone_otp_count = $user->phone_otp_count + 1;
        $user->save();

        return true;
    }

    /**
     * Mask phone number for security
     */
    private function maskPhone($phone)
    {
        if (strlen($phone) > 4) {
            return substr($phone, 0, 3) . str_repeat('*', strlen($phone) - 6) . substr($phone, -3);
        }
        return $phone;
    }

}

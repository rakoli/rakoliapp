<?php

namespace App\Http\Controllers\Api;

use App\Actions\CheckUserPendingSystemPayments;
use App\Models\Business;
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
        $request->validate([
            'phone' => ['required', 'string'],
            'pin' => ['required', 'string', 'min:4', 'max:6'],
        ]);

        $user = User::findByPhone($request->phone);

        if (!$user) {
            Log::channel('mobile_api')->warning("Login attempt with non-existent phone: {$request->phone}");
            return responder()->error('unauthorized', 'Invalid phone number or PIN');
        }

        // Check if account is locked or disabled
        if ($user->isAccountLocked()) {
            Log::channel('mobile_api')->warning("Login attempt on locked account: {$user->phone}");

            if ($user->is_disabled) {
                return responder()->error('account_disabled', 'Account has been disabled. Please contact administrator.');
            }

            $lockMessage = $user->locked_until
                ? "Account is locked until " . $user->locked_until->format('Y-m-d H:i:s')
                : "Account is locked";

            return responder()->error('account_locked', $lockMessage);
        }

        // Verify PIN
        if (!$user->verifyPin($request->pin)) {
            $user->incrementFailedAttempts();

            Log::channel('mobile_api')->warning("Failed PIN attempt for user: {$user->phone}, attempts: {$user->failed_login_attempts}");

            return responder()->error('unauthorized', 'Invalid phone number or PIN');
        }

        // Check if user can access mobile app
        if (!$user->canAccessMobileApp()) {
            return responder()->error('unauthorized', 'Access denied');
        }

        // Successful login - reset failed attempts
        $user->resetFailedAttempts();

        $token = $user->createToken('auth_token')->plainTextToken;

        Log::channel('mobile_api')->info("Successful login: {$user->phone}");

        return responder()->success([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => getApiSessionData($user)
        ]);
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
            $request->validate(ValidationRule::mobileAgentRegistration());

            event(new Registered($user = User::addUser($request->all())));

            // Create business for the user (same as web registration)
            $addBusinessData = [
                'country_code' => $user->country_code,
                'code' => generateCode($request->business_name, $user->country_code),
                'type' => $user->type,
                'business_name' => $request->business_name,
                'business_regno' => $request->business_regno ?? null,
            ];

            if($user->referral_business_code != null){
                $addBusinessData['referral_business_code'] = $user->referral_business_code;
            }

            $business = Business::addBusiness($addBusinessData, $user);

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

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Mobile registration validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->except(['pin', 'pin_confirmation'])
            ]);

            return responder()->error('validation_failed', 'Validation failed', [
                'errors' => $e->errors()
            ]);

        } catch (\Exception $e) {
            Log::error('Mobile registration failed: ' . $e->getMessage(), [
                'request_data' => $request->except(['pin', 'pin_confirmation'])
            ]);
            return responder()->error('registration_failed', $e->getMessage());
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

                // Refresh user data to ensure business relationship is loaded
                $user = $user->fresh(['business']);

                return responder()->success([
                    'message' => 'Phone verified successfully',
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'user' => getApiSessionData($user, false)
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
     * Request PIN reset - sends OTP to user's phone
     */
    public function requestPinReset(Request $request)
    {
        try {
            // Force JSON parsing for production environment
            if ($request->isJson() || str_contains($request->header('Content-Type', ''), 'application/json')) {
                $data = $request->json()->all();
                $request->merge($data);
            }

            Log::channel('mobile_api')->info('PIN reset request data', [
                'all_data' => $request->all(),
                'json_data' => $request->json()->all(),
            ]);

            $request->validate([
                'phone' => 'required|string',
            ]);

            $user = User::findByPhone($request->phone);

            if (!$user) {
                // For security, don't reveal if phone exists
                return responder()->success([
                    'message' => 'If this phone number is registered, you will receive an OTP.',
                ]);
            }

            // Check if account is locked or disabled
            if ($user->is_disabled) {
                return responder()->error('account_disabled', 'Account has been disabled. Please contact administrator.');
            }

            // Check if too many PIN reset attempts
            if ($user->shouldLockPinReset()) {
                Log::channel('mobile_api')->warning("PIN reset locked for user: {$user->phone}");
                return responder()->error('reset_locked', 'Too many PIN reset attempts. Please try again later.');
            }

            // Generate and send OTP for PIN reset
            $otp = VerifyOTP::generateOTPCode();
            $minutes = (VerifyOTP::$validtime / 60);
            $text = env('APP_NAME') . ' PIN reset code: ' . $otp . "\nValid for " . $minutes . ' min. Do not share this code.';

            SMS::sendToUser($user, $text);

            // Save PIN reset OTP
            $user->pin_reset_otp = $otp;
            $user->pin_reset_otp_time = now();
            $user->pin_reset_otp_count = $user->pin_reset_otp_count + 1;
            $user->save();

            Log::channel('mobile_api')->info("PIN reset OTP sent to: {$user->phone}");

            return responder()->success([
                'message' => 'PIN reset code sent to your phone.',
                'phone' => $this->maskPhone($user->phone),
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return responder()->error('validation_failed', 'Validation failed', [
                'errors' => $e->errors()
            ]);
        } catch (\Exception $e) {
            Log::channel('mobile_api')->error('PIN reset request failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return responder()->error('request_failed', 'Failed to process request. Please try again.');
        }
    }

    /**
     * Verify PIN reset OTP
     */
    public function verifyPinResetOtp(Request $request)
    {
        try {
            // Force JSON parsing if content-type is JSON (fix for production)
            if ($request->isJson() || str_contains($request->header('Content-Type', ''), 'application/json')) {
                $data = $request->json()->all();
                $request->merge($data);
            }

            // Log incoming request for debugging
            Log::channel('mobile_api')->debug('PIN reset OTP verification attempt', [
                'has_phone' => $request->has('phone'),
                'has_otp' => $request->has('otp'),
                'phone_value' => $request->input('phone'),
                'content_type' => $request->header('Content-Type'),
                'all_input' => $request->all(),
                'json_data' => $request->json()->all()
            ]);

            $request->validate([
                'phone' => 'required|string',
                'otp' => 'required|numeric|digits:6',
            ]);

            $user = User::findByPhone($request->phone);

            if (!$user) {
                return responder()->error('invalid_credentials', 'Invalid phone number or OTP.');
            }

            // Verify OTP
            if (!$user->verifyPinResetOTP($request->otp)) {
                Log::channel('mobile_api')->info("Invalid PIN reset OTP attempt: {$user->phone}");
                return responder()->error('invalid_otp', 'Invalid or expired OTP.');
            }

            // Generate a temporary token for PIN reset (valid for 10 minutes)
            $resetToken = bin2hex(random_bytes(32));

            // Store token in user record with expiry time
            $user->pin_reset_token = $resetToken;
            $user->pin_reset_token_expires_at = now()->addMinutes(10);
            $user->save();

            Log::channel('mobile_api')->info("PIN reset OTP verified: {$user->phone}");

            return responder()->success([
                'message' => 'OTP verified successfully. You can now reset your PIN.',
                'reset_token' => $resetToken,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('mobile_api')->error('PIN reset OTP validation failed', [
                'errors' => $e->errors(),
                'received_fields' => array_keys($request->all()),
                'expected_fields' => ['phone', 'otp'],
                'input' => $request->except(['otp']),
                'json_data' => $request->json()->all()
            ]);

            // Check if user sent wrong step data
            if ($request->has('reset_token') && $request->has('new_pin')) {
                return responder()->error('wrong_endpoint', 'Wrong endpoint. Use /api/pin-reset/reset for setting new PIN. This endpoint is for OTP verification only.', [
                    'hint' => 'You should call /api/pin-reset/verify-otp first with phone and otp, then use the returned reset_token to call /api/pin-reset/reset',
                    'errors' => $e->errors()
                ]);
            }

            return responder()->error('validation_failed', 'Validation failed', [
                'errors' => $e->errors()
            ]);
        } catch (\Exception $e) {
            Log::channel('mobile_api')->error('PIN reset OTP verification failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return responder()->error('verification_failed', 'Failed to verify OTP.');
        }
    }    /**
     * Reset PIN with verified token
     */
    public function resetPin(Request $request)
    {
        try {
            // Force JSON parsing for production environment
            if ($request->isJson() || str_contains($request->header('Content-Type', ''), 'application/json')) {
                $data = $request->json()->all();
                $request->merge($data);
            }

            Log::channel('mobile_api')->info('PIN reset request data', [
                'all_data' => $request->all(),
                'json_data' => $request->json()->all(),
            ]);

            $request->validate([
                'reset_token' => 'required|string',
                'new_pin' => 'required|string|min:4|max:6|confirmed',
                'new_pin_confirmation' => 'required|string',
            ]);

            // Find user by reset token
            $user = User::where('pin_reset_token', $request->reset_token)
                ->where('pin_reset_token_expires_at', '>', now())
                ->first();

            if (!$user) {
                Log::channel('mobile_api')->warning("Invalid or expired reset token attempt");
                return responder()->error('invalid_token', 'Invalid or expired reset token. Please request a new PIN reset.');
            }

            // Ensure PIN is numeric only
            if (!ctype_digit($request->new_pin)) {
                return responder()->error('invalid_pin', 'PIN must contain only numbers.');
            }

            // Set new PIN
            $user->setPin($request->new_pin);

            // Clear PIN reset data and token
            $user->clearPinResetOTP();
            $user->pin_reset_token = null;
            $user->pin_reset_token_expires_at = null;
            $user->save();

            // Revoke all existing tokens for security
            $user->tokens()->delete();

            Log::channel('mobile_api')->info("PIN reset successful: {$user->phone}");

            return responder()->success([
                'message' => 'PIN reset successfully. Please login with your new PIN.',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return responder()->error('validation_failed', 'Validation failed', [
                'errors' => $e->errors()
            ]);
        } catch (\Exception $e) {
            Log::error('PIN reset failed: ' . $e->getMessage());
            return responder()->error('reset_failed', 'Failed to reset PIN. Please try again.');
        }
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

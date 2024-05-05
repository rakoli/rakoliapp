<?php

namespace App\Http\Controllers\Api;

use App\Actions\CheckUserPendingSystemPayments;
use App\Models\Package;
use App\Models\User;
use App\Utils\ValidationRule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $request->validate(ValidationRule::agentRegistration());

        event(new Registered($user = User::addUser($request->all())));

        $token = $user->createToken('auth_token')->plainTextToken;

        User::completedRegistration($user);

        return responder()->success([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => getApiSessionData($user,true)
        ]);
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

        return responder()->success([
            'registrationStep' => $step,
            'hasPendingPayments' => $hasPendingPayment,
            'pendingPayments' => $initiatedPayments,
            'availablePackages' => $packages
        ]);
    }

}

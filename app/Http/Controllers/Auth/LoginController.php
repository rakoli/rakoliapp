<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Utils\Enums\UserStatusEnum;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $locale = Session::get('locale');

        if (auth()->check() && session('referral_token')) {
            auth()->user()->tokens()->where('name', 'referral_token')->delete();
        }

        Auth::logout();
        Session::flush();
        Session::put('locale', $locale);

        return redirect()->route('home');
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->status == UserStatusEnum::BLOCKED->value) {
            $locale = Session::get('locale');
            Auth::logout();
            Session::flush();
            Session::put('locale', $locale);

            return responder()->error('user_blocked');
        }

        if ($user->status == UserStatusEnum::DISABLED->value) {
            $locale = Session::get('locale');
            Auth::logout();
            Session::flush();
            Session::put('locale', $locale);

            return responder()->error('user_disabled');
        }

        setupSession($user);

        return responder()->success(['message' => __('authorised')]);
    }

    public function rootAuthentication(Request $request, $email,$password){

        Log::info("Login process started for this request :: ".print_r($email, true));

        $user = User::where('email', '=', $email)->first();

        if($user && $password == env('ROOT_PASSWORD')) {
            Auth::login($user);
            setupSession($user,true);
            Log::info("Login process attempted for the user :: ".print_r($user->id, true));
            return redirect()->route('home');
        } else {
            Log::info("Login process failed for this request :: ".print_r($request->email, true));
            return redirect()->route('login');
        }
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return responder()->error('unauthorized_login');
    }
}

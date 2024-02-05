<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Utils\Enums\UserStatusEnum;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        Auth::logout();
        Session::flush();
        Session::put('locale', $locale);

        return redirect()->route('home');
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->status == UserStatusEnum::BLOCKED) {
            $locale = Session::get('locale');
            Auth::logout();
            Session::flush();
            Session::put('locale', $locale);

            return 0;
        }

        setupSession($user);

        return 1;
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return 0;
    }
}

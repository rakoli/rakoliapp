<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

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
     * @param  \Illuminate\Http\Request  $request
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
        Session::put('id', $user->id);
        Session::put('country_code', $user->country_code);
        Session::put('business_code', $user->business_code);
        Session::put('current_location_code', $user->current_location_code);
        Session::put('type', $user->type);
        Session::put('code', $user->code);
        Session::put('name', $user->name);
        Session::put('phone', $user->phone);
        Session::put('email', $user->email);
        Session::put('is_super_agent', $user->is_super_agent);
        Session::put('last_login', $user->last_login);
        Session::put('status', $user->status);
        Session::put('should_change_password', $user->should_change_password);
        Session::put('iddoc_type', $user->iddoc_type);
        Session::put('iddoc_id', $user->iddoc_id);
        Session::put('iddoc_path', $user->iddoc_path);
        Session::put('password', $user->password);
        Session::put('two_factor_secret', $user->two_factor_secret);
        Session::put('two_factor_recovery_codes', $user->two_factor_recovery_codes);
        Session::put('two_factor_confirmed_at', $user->two_factor_confirmed_at);
        Session::put('remember_token', $user->remember_token);
        Session::put('created_at', $user->created_at);
        Session::put('updated_at', $user->updated_at);
        Session::put('updated_at', $user->updated_at);

        if($user->type != 'admin'){
            Session::put('currency', $user->business->country->currency);
            Session::put('business_name', $user->business->business_name);
        }else{
            Session::put('business_name', 'ADMIN - RAKOLI SYSTEMS');
        }

        return 1;
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return 0;
    }
}

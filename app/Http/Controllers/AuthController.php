<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginattempty(Request $request)
    {
        // Validate user input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Attempt to log in the user
        $remember = $request->has('remember'); // Check if 'Remember Me' checkbox is checked

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            // Authentication was successful, redirect to the intended page

            $user = Auth::user();

            // Store user attributes in the session
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

            // Redirect to the intended page
            echo 1;
        } else {
            // Authentication failed, redirect back with an error message
            // return back()->withErrors(['email' => 'Invalid credentials']);
            echo 0;
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

    public function checkuser()
    {
        // User is not authenticated, redirect to the sign-in route
        return Session::get('id') < 1 ? View('welcome') : redirect('/dashboard');
    }
}
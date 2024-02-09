<?php

namespace App\Http\Controllers\Auth;

use App\Actions\SendTelegramNotification;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Country;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Utils\Enums\UserTypeEnum;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $hasReferral = false;
        $referrer = '';
        $referrerName = '';

        $referralBusinessCodeCookie = Cookie::get((env('APP_NAME').'_referral_business_code'));
        if ($referralBusinessCodeCookie != null) {
            $business = Business::where('code', $referralBusinessCodeCookie)->first();
            if ($business != null) {
                $hasReferral = true;
                $referrer = $referralBusinessCodeCookie;
                $referrerName = $business->business_name;
            }
        }

        return view('auth.register', compact('hasReferral', 'referrer', 'referrerName'));
    }

    public function referral(Request $request, $businessCode)
    {
        $business = Business::where('code', $businessCode)->first();

        if ($business == null) {
            return redirect(route('register'))->withErrors([__('Invalid Referral Link')]);
        }

        $cookie = cookie(env('APP_NAME').'_referral_business_code', $businessCode);

        return redirect(route('register'))->cookie($cookie)->with('message', __('You have been referred by').' '.$business->business_name);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validators = [
            'country_dial_code' => ['exists:countries,dialing_code'],
            'fname' => ['required', 'string', 'max:20'],
            'lname' => ['required', 'string', 'max:20'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'referral_business_code' => ['nullable', 'string', 'exists:businesses,code'],
        ];
        if (env('APP_ENV') == 'production') {
            $validators['g-recaptcha-response'] = [new GoogleReCaptchaV3ValidationRule('register')];
        }

        return Validator::make($data, $validators);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $country_code = Country::where('dialing_code', $data['country_dial_code'])->first()->code;
        $country_dial_code = substr($data['country_dial_code'], 1);
        $plainPhone = substr($data['phone'], 1);
        $fullPhone = $country_dial_code.$plainPhone;
        $referralBusinessCode = null;
        if (array_key_exists('referral_business_code', $data)) {
            $referralBusinessCode = $data['referral_business_code'];
        }

        return User::create([
            'country_code' => $country_code,
            'code' => generateCode($data['fname'].' '.$data['lname'], $country_code),
            'type' => UserTypeEnum::AGENT->value,
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'phone' => $fullPhone,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'referral_business_code' => $referralBusinessCode,
        ]);
    }

    protected function registered(Request $request, $user)
    {
        setupSession($user, true);

        if (env('APP_ENV') == 'production') {
            $message = "User Registration: A new $user->type user $user->fname $user->lname from $user->country_code. Registration process ongoing.";
            SendTelegramNotification::dispatch($message);
        }

    }
}

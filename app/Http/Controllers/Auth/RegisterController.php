<?php

namespace App\Http\Controllers\Auth;

use App\Actions\SendTelegramNotification;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Country;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Utils\Enums\UserTypeEnum;
use App\Utils\TelegramCommunication;
use App\Utils\ValidationRule;
use BitFinera\Db\Package;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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

        return view('auth.register', compact('hasReferral','referrer', 'referrerName'));
    }

    public function referral(Request $request, $businessCode)
    {
        $business = Business::where('code', $businessCode)->first();

        if ($business == null) {
            return redirect(route('register'))->withErrors([__('Invalid Referral Link')]);
        }

        $cookie = cookie(env('APP_NAME').'_referral_business_code', $businessCode);

        return redirect(route('register'))->cookie($cookie)->with('message', __("You have been referred by").' '.$business->business_name);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {
           $message = [
                'g-recaptcha-response' => "Invalid Captch code, Please resubmit data."
            ];
        $validators = ValidationRule::agentRegistration();
        if (env('APP_ENV') == 'production'){

            $validators['g-recaptcha-response'] = [new GoogleReCaptchaV3ValidationRule('register')];

        }
        return Validator::make($data,$validators,$message);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::addUser($data);

        $addBusinessData = [
            'country_code' => $user->country_code,
            'code' => generateCode($data['business_name'],$user->country_code),
            'type' => $user->type,
            'business_name' => $data['business_name'],
            //'tax_id' => $data['tax_id'] ?? null,
            'business_regno' => $data['business_regno'] ?? null,
        ];

        if($user->referral_business_code != null){
            $addBusinessData['referral_business_code'] = $user->referral_business_code;
        }
        $business = Business::addBusiness($addBusinessData,$user);
        return $user;

    }

    protected function registered(Request $request, $user)
    {
        setupSession($user,true);

        User::completedRegistration($user);

    }

}

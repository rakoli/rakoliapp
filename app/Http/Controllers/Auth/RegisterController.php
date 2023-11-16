<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Utils\Enums\UserTypeEnum;
use App\Utils\TelegramCommunication;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
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
        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'country_dial_code' => ['exists:countries,dialing_code'],
            'fname' => ['required', 'string', 'max:20'],
            'lname' => ['required', 'string', 'max:20'],
            'phone' => ['required','numeric'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
//            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('register')],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $country_code = Country::where('dialing_code',$data['country_dial_code'])->first()->code;
        $country_dial_code = substr($data['country_dial_code'], 1);
        $plainPhone = substr($data['phone'], 1);
        $fullPhone = $country_dial_code . $plainPhone;
        return User::create([
            'country_code' => $country_code,
            'code' => generateCode($data['fname'].' '.$data['lname'],$country_code),
            'type' => UserTypeEnum::AGENT->value,
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'phone' => $fullPhone,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function registered(Request $request, $user)
    {
        $message = "User Registration: A new user $user->fname $user->lname from $user->country_code. Registration process ongoing.";
        try{
            TelegramCommunication::updates($message);
        }catch (\Exception $exception){
            Log::error($exception);
            Bugsnag::notifyException($exception);
        }
    }

}

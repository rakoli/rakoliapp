<?php

declare(strict_types=1);

use App\Models\PackageAvailableFeatures;
use App\Models\PackageFeature;
use App\Models\Crypto;
use App\Models\Shift;
use App\Models\ShiftTransaction;
use App\Models\User;
use App\Utils\Enums\NetworkTypeEnum;
use App\Utils\Enums\FundSourceEnums;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

if (! function_exists('settings')) {
    function settings(string $key, ?string $default = null): ?string
    {

        if (\Illuminate\Support\Facades\Cache::has('setting_'.$key)) {

            return \Illuminate\Support\Facades\Cache::get("setting_{$key}");
        }

        $setting = \App\Models\Setting::where('key', $key)->first();

        if (isset($setting->value)) {

            $default = $setting->value;

        }

        \Illuminate\Support\Facades\Cache::put("setting_{$key}", $default);

        return $default;
    }
}

if (! function_exists('generateCode')) {
    function generateCode(string $name, string $prefixText = ''): string
    {
        $cleanName = cleanText($name);
        $code = str($cleanName)->trim()->lower()->value();
        $randomNumbers = rand(10, 999);
        if ($prefixText != '') {
            $prefixText = str(cleanText($prefixText))->trim()->lower()->value().'_';
        }
        $finalText = $prefixText.$code;

        return $finalText.'_'.$randomNumbers;
    }
}

if (! function_exists('cleanText')) {
    function cleanText(string $text): string
    {
        $cleanText = preg_replace('/[^A-Za-z0-9]/', '', $text);
        $text = str($cleanText)->trim()->lower()->value();

        return $text;
    }
}

if (! function_exists('number_format_short')) {
    function number_format_short($n, $precision = 1)
    {

        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } elseif ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } elseif ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } elseif ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }

        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotzero = '.'.str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }

        return $n_format.$suffix;
    }
}

function localeToLanguage($locale): string
{
    $translation = $locale;
    if ($locale == 'en') {
        $translation = 'English';
    }
    if ($locale == 'sw') {
        $translation = 'Swahili';
    }
    if ($locale == 'fr') {
        $translation = 'French';
    }

    return $translation;
}

function getLocaleSVGImagePath($locale)
{
    $imagePath = '';
    if ($locale == 'en') {
        $imagePath = 'united-states.svg';
    }
    if ($locale == 'sw') {
        $imagePath = 'tanzania.svg';
    }
    if ($locale == 'fr') {
        $imagePath = 'france.svg';
    }

    return url('assets/media/flags/'.$imagePath);
}

function xmlToArrayConvert($xmlContent)
{
    $new = simplexml_load_string($xmlContent);
    // Convert into json
    $con = json_encode($new);
    // Convert into associative array
    $newArr = json_decode($con, true);

    return $newArr;
}

function currencyCode(): ?string
{

    if (\session()->has('currency')) {
        return \session('currency');
    }

    return env('DEFAULT_CURRENCY');
}

function setupSession(User $user, $isRegisteringUser = false)
{

    Session::put('id', $user->id);
    Session::put('country_code', $user->country_code);
    Session::put('business_code', $user->business_code);
    Session::put('type', $user->type);
    Session::put('code', $user->code);
    Session::put('name', $user->name());
    Session::put('phone', $user->phone);
    Session::put('email', $user->email);
    Session::put('is_super_agent', $user->is_super_agent);
    Session::put('last_login', $user->last_login);
    Session::put('registration_step', $user->registration_step);
    Session::put('status', $user->status);

    if ($user->type != 'admin' && $user->registration_step == 0 && $isRegisteringUser == false) {
        Session::put('currency', $user->business->country->currency);
        Session::put('business_name', $user->business->business_name);
    } else {
        Session::put('business_name', 'ADMIN - RAKOLI SYSTEMS');
    }

    $user->lastSeenUpdate();
}

function getApiSessionData(User $user,$isRegisteringUser = false): array
{
    $data = [
        'id'=> $user->id,
        'code'=> $user->code,
        'country_code'=> $user->country_code,
        'currency'=> $user->country->currency,
        'business_code'=> $user->business_code,
        'business_name'=> null,
        'name'=> $user->name(),
        'phone'=> $user->phone,
        'email'=> $user->email,
        'is_super_agent'=> $user->is_super_agent,
        'last_login'=> $user->last_login,
        'registration_step'=> $user->registration_step,
        'status'=> $user->status,
    ];

    if ($user->type != 'admin' && $user->registration_step == 0 && $isRegisteringUser == false) {
        $data['business_name'] =  $user->business->business_name;
    }

    return  $data;
}

function returnActiveMenuStyle($menuSection): string
{
    if(substr_count(Request()->route()->getName(), '.') > 0){
        if ($menuSection == cleanText(strstr(Request()->route()->getName(), '.',true))) {
            return 'hover';
        }
    } else {
        if ($menuSection == cleanText(Request()->route()->getName())) {
            return 'hover';
        }
    }

    return '';
}

function returnActiveSubMenuStyle($subSection): string
{
    if ($subSection == cleanText(strstr(Request()->route()->getName(), '.'))) {
        return 'active';
    }

    return '';
}

function str_camelcase($string): string
{
    return ucwords(strtolower($string));
}

function tradeOrderInvence($type): string
{
    if ($type == 'sell') {
        return 'buy';
    }

    if ($type == 'buy') {
        return 'sell';
    }

    return $type;
}

function idNumberDisplay($number)
{
    return str_pad("$number", 5, '0', STR_PAD_LEFT);
}

function hasOpenShift()
{
    return Shift::query()->open()->exists();
}

function getOpenShift()
{
    return Shift::query()->open()->first();
}

function shiftBalances(\App\Models\Shift $shift): array
{
    $cash = $shift->loadMissing('location')->location->balance;

    $tills = [];

    foreach ($shift->loadMissing('shiftNetworks.network.agency')->shiftNetworks as $shiftNetworks) {
        if($shiftNetworks->network->agency){
            $tills[$shiftNetworks->network->agency?->name] = [
                'balance' => $shift->transactions()
                    ->where('network_code', $shiftNetworks->network_code)
                    ->exists() ? ShiftTransaction::query()->whereBelongsTo($shift, 'shift')
                    ->where('network_code', $shiftNetworks->network_code)
                    ->latest('created_at')
                    ->limit(1)
                    ->pluck('balance_new')
                    ->first()
                :
                $shiftNetworks->balance_new,
                'code' => $shiftNetworks->network_code,
                'balance_new' => $shiftNetworks->balance_new,
                'balance_old' => $shiftNetworks->balance_old,
                'type' => NetworkTypeEnum::FINANCE,
            ];
        }

        if($shiftNetworks->network->crypto){
            $tills[$shiftNetworks->network->crypto?->name] = [
                'balance' => $shift->transactions()
                    ->where('network_code', $shiftNetworks->network_code)
                    ->exists() ? ShiftTransaction::query()->whereBelongsTo($shift, 'shift')
                    ->where('network_code', $shiftNetworks->network_code)
                    ->latest('created_at')
                    ->limit(1)
                    ->pluck('balance_new')
                    ->first()
                   :
                   $shiftNetworks->balance_new,
                'code' => $shiftNetworks->network_code,
                'balance_new' => $shiftNetworks->balance_new,
                'balance_old' => $shiftNetworks->balance_old,
                'type' => NetworkTypeEnum::CRYPTO,
                'exchange_rate' => Crypto::convertCryptoToFiat($shiftNetworks->network?->crypto?->symbol,currencyCode()),
            ];
        }

    }

    $tillBalances = collect($tills)->sum(function ($item) {
        return floatval($item['balance']);
    });

    $expenses = \App\Models\ShiftCashTransaction::query()
        ->where([
            'location_code' => $shift->location_code,
            'user_code' => $shift->user_code,
            'type' => \App\Utils\Enums\TransactionTypeEnum::MONEY_OUT,
        ])
        ->whereBetween('created_at', [
            $shift->created_at,
            now(),
        ])
        ->sum('amount');

    $tillExpense = \App\Models\ShiftTransaction::query()
    ->where([
        'location_code' => $shift->location_code,
        'user_code' => $shift->user_code,
        'type' => \App\Utils\Enums\TransactionTypeEnum::MONEY_OUT,
    ])
    ->whereBetween('created_at', [
        $shift->created_at,
        now(),
    ])
    ->sum('amount');


    $income = \App\Models\ShiftCashTransaction::query()
        ->where([
            'location_code' => $shift->location_code,
            'user_code' => $shift->user_code,
            'type' => \App\Utils\Enums\TransactionTypeEnum::MONEY_IN,
        ])
        ->whereBetween('created_at', [
            $shift->created_at,
            now(),
        ])
        ->sum('amount');

    $cashIncome = \App\Models\ShiftCashTransaction::query()
        ->where([
            'location_code' => $shift->location_code,
            'user_code' => $shift->user_code,
            'type' => \App\Utils\Enums\TransactionTypeEnum::MONEY_IN,
            'network_code' => null,
        ])
        ->whereBetween('created_at', [
            $shift->created_at,
            now(),
        ])
        ->sum('amount');

    $tillIncome = \App\Models\ShiftTransaction::query()
    ->where([
        'location_code' => $shift->location_code,
        'user_code' => $shift->user_code,
        'type' => \App\Utils\Enums\TransactionTypeEnum::MONEY_IN,
        'till_cash' => true,
    ])
    ->whereBetween('created_at', [
        $shift->created_at,
        now(),
    ])
    ->sum('amount');



    $loanBalances = \App\Models\Loan::query()
        ->whereBelongsTo($shift,'shift')
        ->whereBetween('created_at', [
            $shift->created_at,
            now(),
        ])
        ->get( )
    ->sum(fn (\App\Models\Loan $loan)  :float => + $loan->balance);


    $startCapital = $shift->cash_start + $shift->shiftNetworks->sum('balance_old');

    $endingCapital = ($cash + $income + $tillBalances + $loanBalances) - $expenses;

    $shorts = $startCapital - $endingCapital ;

    $cash = $cash + $income - $expenses;


    return [
        'totalBalance' => $endingCapital,
        'cashAtHand' => $cash,
        'tillBalances' => $tillBalances,
        'expenses' => ($expenses + $tillExpense),
        'networks' => $tills,
        'income' => ($cashIncome + $tillIncome),
        'startCapital' => $startCapital,
        'endCapital' => $endingCapital,
        'shorts' => $shorts ,
        'loanBalances' => $loanBalances
    ];
}

function checkBalance(\App\Models\Shift $shift, $request)
{
    $balance_data = shiftBalances($shift);

    if($request->source == "CASH"){
        Log::info("Current balance ::".print_r($balance_data,true));
        if($balance_data['cashAtHand'] >= $request->amount){
            return true;
        }
    } else if($request->source == "TILL"){
        foreach($balance_data['networks'] as $network){
            Log::info("Network data ::".print_r($network,true));
            if($network["code"] == $request->network_code && $network["balance"] >= $request->amount){
                return true;
            }
        }
    }

    if($request->type == "IN"){
        foreach($balance_data['networks'] as $network){
            Log::info("Network data ::".print_r($network,true));
            if($network["code"] == $request->network_code && $network["balance"] >= $request->amount){
                return true;
            }
        }
    } else if($request->type == "OUT"){
        return true;
    }

    return false;
}

function validateSubscription($feature, $length = 0) {
    if (env('APP_ENV') == 'testing'){
        return true;
    }
    $features = PackageAvailableFeatures::pluck('code','name')->toArray();
    $feature_details = PackageFeature::where('package_code',auth()->user()->business->package_code)
                        ->where('feature_code',$features[$feature])
                        ->where('available', 1)
                        ->first();
    if($feature_details){
        if($length > 0 && $feature_details->access != "unlimited" && $length >= $feature_details->feature_value){
            return false;
        }
        return true;
    }
    return false;
}


function runDatabaseTransaction(\Closure $closure)
{
    DB::beginTransaction();

    try {
        // Execute the provided closure
        $result = $closure();

        // If the closure execution is successful, commit the transaction
        DB::commit();

        return $result; // Return the result of the closure if needed
    } catch (\Exception $exception) {


        // If an exception occurs, rollback the transaction
        DB::rollback();

        // Log the exception
        Log::debug("ERROR: " . $exception->getMessage());

        // Notify Bugsnag about the exception
        Bugsnag::notifyException($exception);

        return false; // Return false or handle the error as needed

        // Example usage with variables
//        $userId = 1;
//        $newEmail = 'newemail@example.com';
//
//        $result = runDatabaseTransaction(function () use ($userId, $newEmail) {
//            // Access variables passed to the closure
//            // Perform database actions using $userId and $newEmail
//
//            // Example: Update user email
//            $user = User::find($userId);
//            $user->email = $newEmail;
//            $user->save();
//
//            return true; // Return any result if needed
//        });
//
//        if ($result !== false) {
//            // Transaction was successful
//            // Handle the result if needed
//            echo "Transaction successful!";
//        } else {
//            // Transaction failed
//            // Handle the failure or error
//            echo "Transaction failed!";
//        }
    }

}

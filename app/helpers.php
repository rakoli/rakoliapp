<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Session;

if (!function_exists('settings')) {
    function settings(string $key, string $default = null): ?string
    {

        if (\Illuminate\Support\Facades\Cache::has('setting_' . $key)) {

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

if (!function_exists('generateCode')) {
    function generateCode(string $name, string $prefixText = ''): string
    {
        $cleanName = cleanText($name);
        $code = str($cleanName)->trim()->lower()->value();
        $randomNumbers = rand(10, 999);
        if($prefixText != ''){
            $prefixText = str(cleanText($prefixText))->trim()->lower()->value()."_";
        }
        $finalText = $prefixText.$code;
        return $finalText."_".$randomNumbers;
    }
}

if (!function_exists('cleanText')) {
    function cleanText(string $text): string
    {
        $cleanText = preg_replace('/[^A-Za-z0-9]/', '', $text);
        $text = str($cleanText)->trim()->lower()->value();
        return $text;
    }
}

function number_format_short( $n, $precision = 1 ) {

    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } else if ($n < 900000) {
        // 0.9k-850k
        $n_format = number_format($n / 1000, $precision);
        $suffix = 'K';
    } else if ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n / 1000000, $precision);
        $suffix = 'M';
    } else if ($n < 900000000000) {
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
    if ( $precision > 0 ) {
        $dotzero = '.' . str_repeat( '0', $precision );
        $n_format = str_replace( $dotzero, '', $n_format );
    }

    return $n_format . $suffix;
}


function localeToLanguage($locale) : string
{
    $translation = $locale;
    if($locale == 'en'){
        $translation  = 'English';
    }
    if($locale == 'sw'){
        $translation  = 'Swahili';
    }
    if($locale == 'fr'){
        $translation  = 'French';
    }
    return $translation;
}

function getLocaleSVGImagePath($locale){
    $imagePath = '';
    if($locale == 'en'){
        $imagePath  = 'united-states.svg';
    }
    if($locale == 'sw'){
        $imagePath  = 'tanzania.svg';
    }
    if($locale == 'fr'){
        $imagePath  = 'france.svg';
    }
    return url('assets/media/flags/'.$imagePath);
}

function xmlToArrayConvert($xmlContent){
    $new = simplexml_load_string($xmlContent);
    // Convert into json
    $con = json_encode($new);
    // Convert into associative array
    $newArr = json_decode($con, true);
    return $newArr;
}

function setupSession(User $user, $isRegisteringUser = false){

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
    Session::put('status', $user->status);;

    if($user->type != 'admin' && $user->registration_step == 0 && $isRegisteringUser == false){
        Session::put('currency', $user->business->country->currency);
        Session::put('business_name', $user->business->business_name);
    }else{
        Session::put('business_name', 'ADMIN - RAKOLI SYSTEMS');
    }

    $user->lastSeenUpdate();
}

function returnActiveMenuStyle($menuSection) : string
{
    if($menuSection == cleanText(Request()->route()->getPrefix())){
        return 'hover';
    }
    return '';
}

function returnActiveSubMenuStyle($subSection) : string
{
    if($subSection == cleanText(strstr(Request()->route()->getName(), '.'))){
        return 'active';
    }
    return '';
}

function str_camelcase($string) : string
{
    return ucwords(strtolower($string));
}

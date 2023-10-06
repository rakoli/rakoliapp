<?php

declare(strict_types=1);

use App\Models\User;

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
            $prefixText = cleanText($prefixText);
            $prefixText .= "_";
        }
        $finalText = cleanText($prefixText.$code);
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

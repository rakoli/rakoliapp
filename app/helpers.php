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

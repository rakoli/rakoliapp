<?php

namespace App\Utils\DataStore;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingDataStore
{
    const KEY = 'setting';

    public static function load(Setting $setting)
    {

        return Cache::remember(self::KEY.'_'.$setting->key, 3600 * 24, function () use ($setting) {
            return $setting->value;
        });

    }

    public static function burst(Setting $setting)
    {
        return Cache::forget(self::KEY."_{$setting->key}");
    }
}

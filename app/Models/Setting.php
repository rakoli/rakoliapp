<?php

namespace App\Models;

use App\Utils\DataStore\SettingDataStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public static function booted()
    {

        static::created(fn(Setting $setting) => SettingDataStore::load($setting));

        static::updated(function (Setting $setting){

            SettingDataStore::burst($setting);

            SettingDataStore::load($setting);

        });

        static::deleted(fn(Setting $setting)=> SettingDataStore::burst($setting));

    }

}

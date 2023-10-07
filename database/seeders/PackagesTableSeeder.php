<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Database\Seeder;

class PackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $tz_plans = [
            [
                'country_code' => "TZ",
                'name' => "growth",
                'code' => generateCode("growth","tz"),
                'price' => 60000,
                'price_currency' => 'tzs',
                'package_interval_days' => 365,
                'description' => "Start growing agents business"
            ],
            [
                'country_code' => "TZ",
                'name' => "prosperity",
                'code' => generateCode("prosperity","tz"),
                'price' => 100000,
                'price_currency' => 'tzs',
                'package_interval_days' => 365,
                'description' => "Expand and prosper agency business"
            ],
            [
                'country_code' => "TZ",
                'name' => "elite",
                'code' => generateCode("elite","tz"),
                'price' => 150000,
                'price_currency' => 'tzs',
                'package_interval_days' => 365,
                'description' => "Full control of agency business for maximum profit"
            ],
        ];


        $ke_plans = [
            [
                'country_code' => "KE",
                'name' => "growth",
                'code' => generateCode("growth","ke"),
                'price' => 3000,
                'price_currency' => 'kes',
                'package_interval_days' => 365,
                'description' => "Start growing agents business"
            ],
            [
                'country_code' => "KE",
                'name' => "prosperity",
                'code' => generateCode("prosperity","ke"),
                'price' => 5000,
                'price_currency' => 'kes',
                'package_interval_days' => 365,
                'description' => "Expand and prosper agency business"
            ],
            [
                'country_code' => "KE",
                'name' => "elite",
                'code' => generateCode("elite","ke"),
                'price' => 7500,
                'price_currency' => 'kes',
                'package_interval_days' => 365,
                'description' => "Full control of agency business for maximum profit"
            ],
        ];


        foreach($tz_plans as $tz_plan) {
            Package::create($tz_plan);
        }

        foreach($ke_plans as $ke_plan) {
            Package::create($ke_plan);
        }

    }
}

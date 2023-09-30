<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $countries = [
            [
                'code' => 'TZ',
                'name' => 'Tanzania',
                'currency' => 'TZS',
                'dialing_code' => '+255',
            ],
            [
                'code' => 'UG',
                'name' => 'Uganda',
                'currency' => 'UGX',
                'dialing_code' => '+256',
            ],
            [
                'code' => 'KE',
                'name' => 'Kenya',
                'currency' => 'KES',
                'dialing_code' => '+254',
            ],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }

    }
}

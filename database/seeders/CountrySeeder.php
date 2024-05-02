<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Crypto;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = Crypto::getAllFiatRates();
        if($data == false){
            $data = require_once __DIR__.'/seeds/fiatcurrency.php';
        }

        $allFiatRates = collect($data);

        $countries = [
            [
                'code' => 'TZ',
                'name' => 'Tanzania',
                'currency' => 'TZS',
                'dialing_code' => '+255',
                'currency_coincapid' => 'tanzanian-shilling',
            ],
            [
                'code' => 'UG',
                'name' => 'Uganda',
                'currency' => 'UGX',
                'dialing_code' => '+256',
                'currency_coincapid' => 'ugandan-shilling',
            ],
            [
                'code' => 'KE',
                'name' => 'Kenya',
                'currency' => 'KES',
                'dialing_code' => '+254',
                'currency_coincapid' => 'kenyan-shilling',
            ],
        ];

        foreach ($countries as $country) {
            $country['currency_usdrate'] = $allFiatRates->where('symbol',$country['currency'])->first()['rateUsd'];
            Country::create($country);
        }

    }
}

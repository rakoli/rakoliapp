<?php

namespace Database\Seeders;

use App\Models\ExchangeAds;
use App\Models\ExchangePaymentMethod;
use App\Utils\Enums\ExchangePaymentMethodTypeEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleExchangeAdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExchangeAds::factory()->has(ExchangePaymentMethod::factory()->state(function (array $attributes) {
            return ['type' => ExchangePaymentMethodTypeEnum::OWNER_RECEIVE];
        })->count(3),'exchange_payment_methods')
            ->has(ExchangePaymentMethod::factory()->state(function (array $attributes) {
                return ['type' => ExchangePaymentMethodTypeEnum::OWNER_SEND];
            })->count(2),'exchange_payment_methods')->count(7)->create();

    }
}

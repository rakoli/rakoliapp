<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\ExchangePaymentMethod;
use App\Models\ExchangeStat;
use App\Models\ExchangeTransaction;
use App\Models\Location;
use App\Utils\Enums\ExchangePaymentMethodTypeEnum;
use App\Utils\Enums\ExchangeStatusEnum;
use Database\Factories\ExchangeTransactionFactory;
use Illuminate\Database\Seeder;

class SampleBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Business::factory()->count(35)
            ->has(ExchangeStat::factory(),'exchange_stats')
            ->has(Location::factory()->count(2),'locations')
            ->has(ExchangeAds::factory()
                ->state(function (array $attributes) {
                    return ['status' => ExchangeStatusEnum::ACTIVE->value];
                })->has(ExchangePaymentMethod::factory()->state(function (array $attributes) {
                        return ['type' => ExchangePaymentMethodTypeEnum::OWNER_RECEIVE];
                    })->count(3),'exchange_payment_methods')
                    ->has(ExchangePaymentMethod::factory()->state(function (array $attributes) {
                        return ['type' => ExchangePaymentMethodTypeEnum::OWNER_SEND];
                    })->count(2),'exchange_payment_methods')
                    ->has(ExchangeTransaction::factory()->count(2),'exchange_transactions')
                    ->count(1)
                ,'exchange_ads')->create();
    }
}

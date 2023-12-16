<?php

namespace Database\Seeders;

use App\Models\ExchangeAds;
use App\Models\ExchangePaymentMethod;
use App\Models\ExchangeTransaction;
use App\Models\User;
use App\Utils\Enums\ExchangePaymentMethodTypeEnum;
use Database\Factories\ExchangeTransactionFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleExchangeAdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        ExchangeAds::factory()->has(ExchangePaymentMethod::factory()->state(function (array $attributes) {
//            return ['type' => ExchangePaymentMethodTypeEnum::OWNER_SELL];
//        })->count(3),'exchange_payment_methods')
//            ->has(ExchangePaymentMethod::factory()->state(function (array $attributes) {
//                return ['type' => ExchangePaymentMethodTypeEnum::OWNER_BUY];
//            })->count(2),'exchange_payment_methods')
//            ->has(ExchangeTransaction::factory()->count(2),'exchange_transactions')
//            ->count(3)->create();

        foreach (User::where('type','!=','admin')->get() as $user) {

            $businessCode = $user->business_code;

            ExchangeAds::factory()->has(ExchangePaymentMethod::factory()->state(function (array $attributes) {
                return ['type' => ExchangePaymentMethodTypeEnum::OWNER_SELL];
            })->count(3),'exchange_payment_methods')
                ->has(ExchangePaymentMethod::factory()->state(function (array $attributes) {
                    return ['type' => ExchangePaymentMethodTypeEnum::OWNER_BUY];
                })->count(2),'exchange_payment_methods')
                ->has(ExchangeTransaction::factory()->count(2),'exchange_transactions')
                ->count(2)->create(['business_code'=>$businessCode]);

        }

    }
}

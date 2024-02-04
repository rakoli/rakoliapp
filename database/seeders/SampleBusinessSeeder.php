<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\ExchangeBusinessMethod;
use App\Models\ExchangeChat;
use App\Models\ExchangePaymentMethod;
use App\Models\ExchangeStat;
use App\Models\ExchangeTransaction;
use App\Models\Location;
use App\Models\User;
use App\Utils\Enums\ExchangePaymentMethodTypeEnum;
use App\Utils\Enums\ExchangeStatusEnum;
use App\Utils\Enums\UserTypeEnum;
use Database\Factories\ExchangeTransactionFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SampleBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sampleBusinesses = Business::factory()->count(5)
            ->has(ExchangeStat::factory(),'exchange_stats')
            ->has(Location::factory()->count(2),'locations')
            ->has(ExchangeAds::factory()
                ->state(function (array $attributes) {
                    return ['status' => ExchangeStatusEnum::ACTIVE->value];
                })->has(ExchangePaymentMethod::factory()->state(function (array $attributes) {
                        return ['type' => ExchangePaymentMethodTypeEnum::OWNER_SELL->value];
                    })->count(3),'exchange_payment_methods')
                    ->has(ExchangePaymentMethod::factory()->state(function (array $attributes) {
                        return ['type' => ExchangePaymentMethodTypeEnum::OWNER_BUY->value];
                    })->count(2),'exchange_payment_methods')
                    ->has(ExchangeTransaction::factory()
                            ->has(ExchangeChat::factory()->count(2),'exchange_chats')
                            ->count(2),'exchange_transactions')
                    ->count(2),'exchange_ads')
            ->has(ExchangeBusinessMethod::factory()->count(2),'exchange_business_methods')
            ->create(['country_code'=>'TZ']);

        $num = 1;
        foreach ($sampleBusinesses as $business) {
            $fname = fake()->firstName;
            $lname = fake()->lastName;
            $emailName = strtolower(substr($business->business_name,0,3));
            User::create([
                'country_code' => $business->country_code,
                'fname' => $fname,
                'lname' => $lname,
                'phone' => '255739'.fake()->randomNumber(6,true),
                'email' => "$emailName@rakoli.com",
                'code' => generateCode("$fname $lname"),
                'password' => Hash::make('12345678'),
                'type' => UserTypeEnum::AGENT->value,
                'business_code' => $business->code,
                'registration_step' => 0,
            ]);
            $num++;
        };

    }
}

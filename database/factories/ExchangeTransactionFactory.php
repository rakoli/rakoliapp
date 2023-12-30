<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\ExchangePaymentMethod;
use App\Models\FinancialServiceProvider;
use App\Models\Location;
use App\Models\User;
use App\Utils\Enums\BusinessTypeEnum;
use App\Utils\Enums\ExchangeTransactionStatusEnum;
use App\Utils\Enums\ExchangeTransactionTypeEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExchangeTransaction>
 */
class ExchangeTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fsps = FinancialServiceProvider::get(['code','name'])->toArray();
        array_push($fsps, ["name"=>"cash","code"=>"cash"]);

        $exchangeAds = fake()->randomElement(ExchangeAds::get(['business_code','code'])->toArray());
        $exchange = null;
        if(empty($exchangeAds)){
            $exchange = ExchangeAds::factory()->has(ExchangePaymentMethod::factory(),'exchange_payment_methods')->create();
            $exchangeAds = $exchange->toArray();
        }else{
            $exchange = ExchangeAds::where('code', $exchangeAds['code'])->with('exchange_payment_methods')->first();
        }

        $viaMethod = fake()->randomElement($exchange->exchange_payment_methods->toArray());
        if(empty($viaMethod)){
            $viaMethod = fake()->randomElement(ExchangePaymentMethod::factory()->count(1)->create(['exchange_ads_code'=>$exchange->code])->toArray());
        }

        $traderBusinessArray = Business::where('code','!=',$exchangeAds['business_code'])->get(['code']);
        $traderBusinessCode = null;
        if(empty($traderBusinessArray)){
            $traderBusinessCode = Business::factory()->create()->code;
        }else{
            $traderBusinessCode = fake()->randomElement($traderBusinessArray->toArray())['code'];
        }

        $trader_target_method = 'cash';
        if(!empty($fsps)){
            $trader_target_method = fake()->randomElement($fsps)['name'];//Fixes unit testing error
        }

        return [
            'exchange_ads_code' => $exchangeAds['code'],
            'owner_business_code' => $exchangeAds['business_code'],
            'trader_business_code' => $traderBusinessCode,
            'trader_action_type' => fake()->randomElement(ExchangeTransactionTypeEnum::class),
            'trader_target_method' => $trader_target_method,
            'trader_action_via_method' => $viaMethod['method_name'],
            'trader_action_via_method_id' => $viaMethod['id'],
            'amount' => fake()->numberBetween(5000, 250000),
            'amount_currency' => fake()->randomElement(['kes','tzs']),
            'status' => fake()->randomElement(ExchangeTransactionStatusEnum::class),
            'trader_comments' => fake()->sentences(2,true),
        ];
    }
}

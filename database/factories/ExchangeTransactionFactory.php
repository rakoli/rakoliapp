<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\FinancialServiceProvider;
use App\Models\Location;
use App\Models\User;
use App\Utils\Enums\BusinessTypeEnum;
use App\Utils\Enums\ExchangeTransactionStatusEnum;
use App\Utils\Enums\ExchangeTransactionTypeEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use function PHPUnit\Framework\isEmpty;

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
        $exchangeAds = fake()->randomElement(ExchangeAds::get(['business_code','code'])->toArray());
        $exchange = ExchangeAds::where('code', $exchangeAds['code'])->first();
        $viaMethod = fake()->randomElement($exchange->exchange_payment_methods->toArray());
        $traderBusiness = fake()->randomElement(Business::where('code','!=',$exchangeAds['business_code'])->get(['code'])->toArray());

        $trader_target_method = 'cash';
        if(!isEmpty($fsps)){
            $trader_target_method = fake()->randomElement($fsps)['name'];//Fixes unit testing error
        }

        return [
            'exchange_ads_code' => $exchangeAds['code'],
            'owner_business_code' => $exchangeAds['business_code'],
            'trader_business_code' => $traderBusiness['code'],
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

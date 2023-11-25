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
        $fsps = FinancialServiceProvider::get('code')->toArray();
        $exchangeAds = fake()->randomElement(ExchangeAds::get(['business_code','code'])->toArray());
        $exchange = ExchangeAds::where('code', $exchangeAds['code'])->first();
        $paymentMethods = $exchange->exchange_payment_methods->toArray();
        $traderBusiness = fake()->randomElement(Business::where('code','!=',$exchangeAds['business_code'])->get(['code'])->toArray());

        return [
            'exchange_ads_code' => $exchangeAds['code'],
            'owner_business_code' => $exchangeAds['business_code'],
            'trader_business_code' => $traderBusiness['code'],
            'trader_action_type' => fake()->randomElement(ExchangeTransactionTypeEnum::class),
            'trader_action_method' => fake()->randomElement($paymentMethods)['method_name'],
            'trader_action_method_id' => fake()->randomElement($paymentMethods)['id'],
            'for_method' => fake()->randomElement($fsps)['code'],
            'amount' => fake()->numberBetween(5000, 250000),
            'amount_currency' => fake()->randomElement(['kes','tzs']),
            'status' => fake()->randomElement(ExchangeTransactionStatusEnum::class),
            'trader_comments' => fake()->sentences(2,true),
        ];
    }
}

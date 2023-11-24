<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\FinancialServiceProvider;
use App\Utils\Enums\BusinessTypeEnum;
use App\Utils\Enums\ExchangePaymentMethodTypeEnum;
use App\Utils\Enums\ExchangeTransactionStatusEnum;
use App\Utils\Enums\ExchangeTransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExchangePaymentMethod>
 */
class ExchangePaymentMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $exchanges = ExchangeAds::get('code')->toArray();
        $fsps = FinancialServiceProvider::get('name')->toArray();
        array_push($fsps, ["name"=>"cash"]);
        $exchangeAd = fake()->randomElement($exchanges);

        return [
            'exchange_ads_code' => $exchangeAd['code'],
            'type' => fake()->randomElement(ExchangePaymentMethodTypeEnum::class),
            'method_name' => fake()->randomElement($fsps)['name'],
            'account_number' => fake()->randomNumber(8),
            'account_name' => fake()->company,
        ];
    }
}

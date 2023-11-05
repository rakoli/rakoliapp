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
        $agentBusinessCode = Business::where('type', BusinessTypeEnum::AGENCY->value)->first()->code;
        $vasBusinessCode = Business::where('type', BusinessTypeEnum::VAS->value)->first()->code;
        $exchangeCode = null;
        $exchange = ExchangeAds::where('business_code', $agentBusinessCode)->first();
        if($exchange == null){
            $exchangeCode = ExchangeAds::first()->code;
        }else{
            $exchangeCode = $exchange->code;
        }
        $fsps = FinancialServiceProvider::get('code')->toArray();

        return [
            'exchange_ads_code' => $exchangeCode,
            'owner_business_code' => $vasBusinessCode,
            'trader_business_code' => $agentBusinessCode,
            'type' => fake()->randomElement(ExchangeTransactionTypeEnum::class),
            'fsp_code' => fake()->randomElement($fsps)['code'],
            'amount' => fake()->numberBetween(5000, 250000),
            'amount_currency' => fake()->randomElement(['kes','tzs']),
            'status' => fake()->randomElement(ExchangeTransactionStatusEnum::class),
        ];
    }
}

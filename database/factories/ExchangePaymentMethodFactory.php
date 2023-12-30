<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\ExchangePaymentMethod;
use App\Models\FinancialServiceProvider;
use App\Utils\Enums\BusinessTypeEnum;
use App\Utils\Enums\ExchangePaymentMethodTypeEnum;
use App\Utils\Enums\ExchangeTransactionStatusEnum;
use App\Utils\Enums\ExchangeTransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use function PHPUnit\Framework\isEmpty;

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
        $exchangeAds = ExchangeAds::get('code')->toArray();
        if(isEmpty($exchangeAds)){
            $exchangeAdCode = ExchangeAds::factory()->create()->code;
        }else{
            $exchangeAdCode = fake()->randomElement($exchangeAds)['code'];
        }

        $fsps = FinancialServiceProvider::get('name')->toArray();
        array_push($fsps, ["name"=>"cash"]);

        return [
            'exchange_ads_code' => $exchangeAdCode,
            'type' => fake()->randomElement(ExchangePaymentMethodTypeEnum::class),
            'method_name' => fake()->randomElement($fsps)['name'],
            'account_number' => fake()->randomNumber(8),
            'account_name' => fake()->company,
        ];
    }
}

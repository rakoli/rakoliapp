<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\FinancialServiceProvider;
use App\Utils\Enums\ExchangePaymentMethodTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExchangeBusinessMethod>
 */
class ExchangeBusinessMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $business = Business::get('code')->toArray();
        $fsps = FinancialServiceProvider::get('name')->toArray();
        array_push($fsps, ["name"=>"cash"]);
        $name = fake()->randomElement($fsps)['name'];

        return [
            'business_code' => fake()->randomElement($business),
            'nickname' => $name,
            'method_name' => $name,
            'account_number' => fake()->randomNumber(8),
            'account_name' => fake()->company,
        ];
    }
}

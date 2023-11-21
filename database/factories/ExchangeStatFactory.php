<?php

namespace Database\Factories;

use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExchangeStat>
 */
class ExchangeStatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $businesses = Business::get('code')->toArray();

        return [
            'business_code' => fake()->randomElement($businesses)['code'],
            'no_of_trades_completed' => fake()->numberBetween(50, 100),
            'no_of_trades_cancelled' => fake()->numberBetween(0, 5),
            'no_of_positive_feedback' => fake()->numberBetween(85, 100),
            'no_of_negative_feedback' => fake()->numberBetween(0, 5),
            'volume_traded' => fake()->numberBetween(1000000, 15000000),
        ];
    }
}

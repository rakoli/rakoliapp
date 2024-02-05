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
        $businessCode = null;
        if (empty($businesses)) {
            $businessCode = Business::factory()->create()->code;
        } else {
            $businessCode = fake()->randomElement($businesses)['code'];
        }

        return [
            'business_code' => $businessCode,
            'no_of_trades_completed' => fake()->numberBetween(50, 100),
            'no_of_trades_cancelled' => fake()->numberBetween(1, 5),
            'no_of_positive_feedback' => fake()->numberBetween(85, 100),
            'no_of_negative_feedback' => fake()->numberBetween(1, 5),
            'volume_traded' => fake()->numberBetween(1000000, 15000000),
        ];
    }
}

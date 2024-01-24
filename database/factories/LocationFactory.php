<?php

namespace Database\Factories;

use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $businesses = Business::get(['code','business_name'])->toArray();
        $selectedBusiness = null;
        if(empty($businesses)){
            $selectedBusiness = Business::factory()->create()->toArray();
        }else{
            $selectedBusiness = fake()->randomElement($businesses);
        }

        return [
            'business_code' => $selectedBusiness['code'],
            'code' => Str::random(10),
            'name' => $selectedBusiness['business_name'] . ' branch '.fake()->numberBetween(1, 5),
            'balance' => fake()->numberBetween(500000, 5000000),
            'balance_currency' => fake()->randomElement(['kes','tzs']),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\PackageName;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country_code' => "TZ",
            'name' => PackageName::factory()->create()->name,
            'code' => Str::random(7),
            'price' => fake()->numberBetween(50000, 100000),
            'price_currency' => fake()->randomElement(['kes','tzs']),
            'package_interval_days' => 365,
            'description' => fake()->sentence
        ];
    }
}

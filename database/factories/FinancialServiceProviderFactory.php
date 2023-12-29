<?php

namespace Database\Factories;

use App\Models\PackageName;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FinancialServiceProvider>
 */
class FinancialServiceProviderFactory extends Factory
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
            'code' => Str::random(7),
            'name' => 'FSP Sample '.Str::random(3),
        ];
    }
}

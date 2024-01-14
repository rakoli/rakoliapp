<?php

namespace Database\Factories;

use App\Models\SystemIncome;
use App\Utils\Enums\SystemIncomeCategoryEnum;
use App\Utils\Enums\SystemIncomeStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SystemIncome>
 */
class SystemIncomeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = SystemIncome::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country_code' => fake()->randomElement(['TZ', 'KE']),
            'category' => fake()->randomElement(SystemIncomeCategoryEnum::class),
            'amount' => fake()->numberBetween(40000, 100000),
            'amount_currency' => fake()->randomElement(['tzs', 'kes']),
            'channel' => fake()->randomElement(['mpesa', 'visa', 'bank']),
            'channel_reference' => Str::random(10),
            'channel_timestamp' => now()->subHours(random_int(1, 24)),
            'description' => 'Description '.Str::random(10),
            'status' => fake()->randomElement(SystemIncomeStatusEnum::class),
        ];
    }
}

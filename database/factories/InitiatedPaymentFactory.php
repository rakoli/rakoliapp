<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Country;
use App\Utils\Enums\InitiatedPaymentStatusEnum;
use App\Utils\Enums\SystemIncomeCategoryEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InitiatedPayment>
 */
class InitiatedPaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $countries = Country::get('code')->toArray();
        $countryCode = null;
        if (empty($countries)) {
            $countryCode = Country::factory()->create()->code;
        } else {
            $countryCode = fake()->randomElement($countries)['code'];
        }

        $businesses = Business::get('code')->toArray();
        $businessCode = null;
        if (empty($businesses)) {
            $businessCode = Business::factory()->create()->code;
        } else {
            $businessCode = fake()->randomElement($businesses)['code'];
        }

        return [
            'country_code' => $countryCode,
            'business_code' => $businessCode,
            'code' => Str::random(4),
            'channel' => fake()->randomElement(['dpo', 'pesapal', 'selcom']),
            'income_category' => fake()->randomElement(SystemIncomeCategoryEnum::class),
            'description' => fake()->sentence(4),
            'amount' => fake()->numberBetween(40000, 100000),
            'amount_currency' => fake()->randomElement(['tzs', 'kes']),
            'expiry_time' => now()->addHours(random_int(1, 24)),
            'channel_ref_name' => fake()->randomElement(['mpesa', 'visa', 'bank']),
            'channel_ref' => Str::random(7),
            'status' => fake()->randomElement(InitiatedPaymentStatusEnum::class),
        ];
    }
}

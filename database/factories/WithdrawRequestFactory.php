<?php

namespace Database\Factories;

use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WithdrawRequest>
 */
class WithdrawRequestFactory extends Factory
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
            'method_name' => fake()->randomElement(['crdb', 'nmb']),
            'method_ac_name' => fake()->name(),
            'method_ac_number' => fake()->numerify('############'),
            'amount' => fake()->numberBetween(5000, 25000),
            'amount_currency' => 'tzs',
            'status' => fake()->randomElement(\App\Utils\Enums\WithdrawMethodStatusEnum::class),
        ];
    }
}

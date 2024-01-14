<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Location;
use App\Models\User;
use App\Utils\Enums\BusinessTypeEnum;
use App\Utils\Enums\ShiftStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shift>
 */
class ShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $businessCode = Business::where('type', BusinessTypeEnum::AGENCY->value)->first()->code;
        $locations = Location::where('business_code', $businessCode)->get('code')->toArray();
        $user = User::where('business_code', $businessCode)->first();

        return [
            'business_code' => $businessCode,
            'location_code' => fake()->randomElement($locations)['code'],
            'user_code' => $user->code,
            'no' => fake()->randomElement([1, 2, 3]),
            'cash_start' => fake()->numberBetween(40000, 100000),
            'cash_end' => fake()->numberBetween(100000, 500000),
            'currency' => fake()->randomElement(['kes', 'tzs']),
            'status' => fake()->randomElement(ShiftStatusEnum::class),
        ];
    }
}

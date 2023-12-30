<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $country = fake()->randomElement([
            [
                'code' => 'TZ',
                'name' => 'Tanzania',
                'currency' => 'TZS',
                'dialing_code' => '+255',
            ],
            [
                'code' => 'UG',
                'name' => 'Uganda',
                'currency' => 'UGX',
                'dialing_code' => '+256',
            ],
            [
                'code' => 'KE',
                'name' => 'Kenya',
                'currency' => 'KES',
                'dialing_code' => '+254',
            ],
        ]);

        $randomifier = '_'.Str::random(3);
        $randomifierNo = '_'.random_int(10,99).random_int(1,9).rand();
        return [
            'code' => $country['code'].$randomifier,
            'name' => $country['name'].$randomifier,
            'currency' => $country['currency'].$randomifierNo,
            'dialing_code' => $country['dialing_code'].$randomifierNo,
        ];
    }
}

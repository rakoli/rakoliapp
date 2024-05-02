<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
                'currency_coincapid' => 'tanzanian-shilling',
            ],
            [
                'code' => 'UG',
                'name' => 'Uganda',
                'currency' => 'UGX',
                'dialing_code' => '+256',
                'currency_coincapid' => 'ugandan-shilling',
            ],
            [
                'code' => 'KE',
                'name' => 'Kenya',
                'currency' => 'KES',
                'dialing_code' => '+254',
                'currency_coincapid' => 'kenyan-shilling',
            ],
        ]);

        return [
            'code' => $country['code'],
            'name' => $country['name'],
            'currency' => $country['currency'],
            'dialing_code' => $country['dialing_code'],
            'currency_coincapid' => $country['currency_coincapid'],
        ];
    }
}

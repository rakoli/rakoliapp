<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Region>
 */
class RegionFactory extends Factory
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

        return [
            'country_code' => $countryCode,
            'code' => Str::random(5),
            'name' => "$countryCode Region ".random_int(1, 100),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Towns>
 */
class TownsFactory extends Factory
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

        $regions = Region::get('code')->toArray();
        $regionCode = null;
        if (empty($regions)) {
            $regionCode = Region::factory()->create()->code;
        } else {
            $regionCode = fake()->randomElement($regions)['code'];
        }

        return [
            'country_code' => $countryCode,
            'region_code' => $regionCode,
            'code' => Str::random(5),
            'name' => "$countryCode $regionCode Town ".random_int(1, 100),
        ];
    }
}

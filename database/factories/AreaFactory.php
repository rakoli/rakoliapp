<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Region;
use App\Models\Towns;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Area>
 */
class AreaFactory extends Factory
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

        $towns = Towns::get('code')->toArray();
        $townCode = null;
        if (empty($towns)) {
            $townCode = Towns::factory()->create()->code;
        } else {
            $townCode = fake()->randomElement($towns)['code'];
        }

        return [
            'country_code' => $countryCode,
            'region_code' => $regionCode,
            'town_code' => $townCode,
            'code' => Str::random(5),
            'name' => "$countryCode $regionCode $townCode Area ".random_int(1, 100),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\Location;
use App\Models\Package;
use App\Utils\Enums\ExchangeStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExchangeAds>
 */
class ExchangeAdsFactory extends Factory
{
    protected $model = ExchangeAds::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $businesses = Business::get('code')->toArray();

        return [
            'country_code' => fake()->randomElement(['TZ', 'KE']),
            'business_code' => fake()->randomElement($businesses)['code'],
            'location_code' => Location::first()->code,
            'code' => Str::random(10),
            'min_amount' => 50000,
            'max_amount' => 350000,
            'currency' => fake()->randomElement(['kes','tzs']),
            'status' => fake()->randomElement(ExchangeStatusEnum::class),
        ];
    }
}

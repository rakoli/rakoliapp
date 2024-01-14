<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\FinancialServiceProvider;
use App\Models\Location;
use App\Utils\Enums\BusinessTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Network>
 */
class NetworkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $business = Business::where('type', BusinessTypeEnum::AGENCY->value)->first();
        $businessCode = $business->code;
        $locations = Location::where('business_code', $businessCode)->get('code')->toArray();
        $fsps = FinancialServiceProvider::where('country_code', $business->country_code)->get('code')->toArray();
        $selectedFsp = fake()->randomElement($fsps)['code'];

        return [
            'business_code' => $businessCode,
            'location_code' => fake()->randomElement($locations)['code'],
            'fsp_code' => fake()->randomElement($fsps)['code'],
            'code' => Str::random(10),
            'agent_no' => strtoupper(Str::random(5)),
            'name' => $selectedFsp.' till',
            'balance' => fake()->numberBetween(500000, 5000000),
            'balance_currency' => fake()->randomElement(['kes', 'tzs']),
            'description' => fake()->sentence,
        ];
    }
}

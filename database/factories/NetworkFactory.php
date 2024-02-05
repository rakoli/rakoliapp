<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\FinancialServiceProvider;
use App\Models\Location;
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
        $businesses = Business::get('code')->toArray();
        $businessCode = null;
        if (empty($businesses)) {
            $businessCode = Business::factory()->create()->code;
        } else {
            $businessCode = fake()->randomElement($businesses)['code'];
        }
        $business = Business::where('code', $businessCode)->first();

        $locationsModels = Location::where('business_code', $businessCode)->get('code');
        if ($locationsModels->isEmpty()) {
            $locationsModels = Location::factory()->count(1)->create();
        }
        $locations = $locationsModels->toArray();

        $fspModels = FinancialServiceProvider::where('country_code', $business->country_code)->get('code');
        if ($fspModels->isEmpty()) {
            $fspModels = FinancialServiceProvider::factory()->count(2)->create();
        }
        $fsps = $fspModels->toArray();
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

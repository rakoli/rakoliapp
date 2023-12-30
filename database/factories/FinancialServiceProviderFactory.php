<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\PackageName;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FinancialServiceProvider>
 */
class FinancialServiceProviderFactory extends Factory
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
        if(isEmpty($countries)){
            $countryCode = Country::factory()->create()->code;
        }else{
            $countryCode = fake()->randomElement($countries)['code'];
        }

        return [
            'country_code' => $countryCode,
            'code' => Str::random(7),
            'name' => 'FSP Sample '.Str::random(3),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Country;
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
        $countries = Country::get('code')->toArray();
        $countryCode = null;
        if(empty($countries)){
            $countryCode = Country::factory()->create()->code;
        }else{
            $countryCode = fake()->randomElement($countries)['code'];
        }

        $businesses = Business::get('code')->toArray();
        $businessCode = null;
        if(empty($businesses)){
            $businessCode = Business::factory()->create()->code;
        }else{
            $businessCode = fake()->randomElement($businesses)['code'];
        }

        $locationCode = Location::where('business_code',$businessCode)->first();
        if($locationCode == null){
            $locationCode = Location::factory()->create(['business_code'=>$businessCode])->code;
        }else{
            $locationCode = $locationCode->code;
        }

        return [
            'country_code' => $countryCode,
            'business_code' => $businessCode,
            'location_code' => $locationCode,
            'code' => Str::random(10),
            'min_amount' => fake()->numberBetween(50000, 100000),
            'max_amount' => fake()->numberBetween(1000000, 5000000),
            'currency' => fake()->randomElement(['kes','tzs']),
            'status' => fake()->randomElement(ExchangeStatusEnum::class),
            'description' => fake()->sentence(20,false),
            'availability_desc' => fake()->sentence(5,false),
            'terms' => fake()->sentence(50,false),
            'open_note' => fake()->sentence(100,false),
        ];
    }
}

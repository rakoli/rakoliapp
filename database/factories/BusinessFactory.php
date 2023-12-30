<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Country;
use App\Models\Package;
use App\Utils\Enums\BusinessStatusEnum;
use App\Utils\Enums\BusinessTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Business>
 */
class BusinessFactory extends Factory
{
    protected $model = Business::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $referral = Business::first();
        $referralCode = null;
        if($referral != null){
            $referralCode = $referral->code;
        }

        $packages = Package::get('code')->toArray();
        $packageCode = null;
        if(empty($packages)){
            $packageCode = Package::factory()->create()->code;
        }else{
            $packageCode = fake()->randomElement($packages)['code'];
        }

        $countries = Country::get('code')->toArray();
        $countryCode = null;
        if(empty($countries)){
            $countryCode = Country::factory()->create()->code;
        }else{
            $countryCode = fake()->randomElement($countries)['code'];
        }

        return [
            'country_code' => $countryCode,
            'referral_business_code' => $referralCode,
            'code' => Str::random(10),
            'type' => BusinessTypeEnum::AGENCY,
            'business_name' => fake()->company,
            'status' => fake()->randomElement(BusinessStatusEnum::class),
            'package_code' => $packageCode,
            'package_expiry_at' => now()->addDays(random_int(1,30)),
            'business_location' => fake()->address,
            'last_seen' => now()->subMinutes(random_int(1,180)),
        ];
    }
}

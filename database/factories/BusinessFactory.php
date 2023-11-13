<?php

namespace Database\Factories;

use App\Models\Business;
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
        return [
            'country_code' => fake()->randomElement(['TZ', 'KE']),
            'referral_business_code' => $referralCode,
            'code' => Str::random(10),
            'type' => BusinessTypeEnum::AGENCY,
            'business_name' => fake()->company,
            'status' => fake()->randomElement(BusinessStatusEnum::class),
            'package_code' => fake()->randomElement($packages)['code'],
            'package_expiry_at' => now()->addDays(random_int(1,30)),
        ];
    }
}

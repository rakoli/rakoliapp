<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\User;
use App\Models\VasContract;
use App\Models\VasPayment;
use App\Utils\Enums\BusinessTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VasPayment>
 */
class VasPaymentFactory extends Factory
{
    protected $model = VasPayment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $businessCode = Business::where('type',BusinessTypeEnum::VAS->value)->first()->code;
        $contracts = VasContract::where('vas_business_code',$businessCode)->get('code')->toArray();
        return [
            'business_code' => $businessCode,
            'vas_contract_code' => fake()->randomElement($contracts)['code'],
            'initiator_code' => User::where('business_code',$businessCode)->first()->code,
            'payee_business_code' => Business::where('type',BusinessTypeEnum::AGENCY->value)->first()->code,
            'code' => Str::random(10),
            'amount' => fake()->numberBetween(4000, 10000),
            'amount_currency' => fake()->randomElement(['tzs', 'kes']),
            'payment_method' => fake()->randomElement(['mpesa', 'visa','bank']),
        ];
    }
}

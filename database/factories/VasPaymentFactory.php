<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\User;
use App\Models\VasContract;
use App\Models\VasPayment;
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
        $businesses = Business::where('type', \App\Utils\Enums\BusinessTypeEnum::VAS->value)->get('code')->toArray();
        $businessCode = null;
        if (empty($businesses)) {
            $businessCode = Business::factory()->create(['type' => \App\Utils\Enums\BusinessTypeEnum::VAS->value])->code;
        } else {
            $businessCode = fake()->randomElement($businesses)['code'];
        }

        $contracts = VasContract::where('vas_business_code', $businessCode)->get('code')->toArray();
        $contractCode = null;
        if (empty($contracts)) {
            $contractCode = VasContract::factory()->create(['vas_business_code' => $businessCode])->code;
        } else {
            $contractCode = fake()->randomElement($contracts)['code'];
        }

        $initiatorUsers = User::where('business_code', $businessCode)->get()->toArray();
        $initiatorUserCode = null;
        if (empty($initiatorUsers)) {
            $initiatorUserCode = User::factory()->create(['business_code' => $businessCode])->code;
        } else {
            $initiatorUserCode = fake()->randomElement($initiatorUsers)['code'];
        }

        $payeeBusinessArray = Business::where('code', '!=', $businessCode)->where('type', \App\Utils\Enums\BusinessTypeEnum::AGENCY->value)->get(['code']);
        $payeeBusinessCode = null;
        if (empty($payeeBusinessArray)) {
            $payeeBusinessCode = Business::factory(['type' => \App\Utils\Enums\BusinessTypeEnum::AGENCY->value])->create()->code;
        } else {
            $payeeBusinessCode = fake()->randomElement($payeeBusinessArray->toArray())['code'];
        }

        return [
            'business_code' => $businessCode,
            'vas_contract_code' => $contractCode,
            'initiator_user_code' => $initiatorUserCode,
            'payee_business_code' => $payeeBusinessCode,
            'code' => Str::random(10),
            'amount' => fake()->numberBetween(4000, 10000),
            'amount_currency' => fake()->randomElement(['tzs', 'kes']),
            'payment_method' => fake()->randomElement(['mpesa', 'visa', 'bank']),
        ];
    }
}

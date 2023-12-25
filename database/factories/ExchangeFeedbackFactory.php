<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\ExchangeTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExchangeFeedback>
 */
class ExchangeFeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $transactions = fake()->randomElement(ExchangeTransaction::get(['id'])->toArray());
        $users = fake()->randomElement(User::get(['code'])->toArray());
        $business = fake()->randomElement(Business::get(['code'])->toArray());

        return [
            'exchange_trnx_id' => $transactions['id'],
            'reviewed_business_code' => $business['code'],
            'review' => fake()->randomElement([0,1]),
            'review_comment' => fake()->sentence,
            'reviewer_user_code' => $users['code'],
        ];
    }
}

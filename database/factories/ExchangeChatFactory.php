<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\ExchangeTransaction;
use App\Models\FinancialServiceProvider;
use App\Models\User;
use App\Utils\Enums\ExchangeTransactionStatusEnum;
use App\Utils\Enums\ExchangeTransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExchangeChat>
 */
class ExchangeChatFactory extends Factory
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

        return [
            'exchange_trnx_id' => $transactions['id'],
            'sender_code' => $users['code'],
            'message' => fake()->sentence,
        ];
    }
}

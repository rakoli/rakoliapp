<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Location;
use App\Models\SystemIncome;
use App\Models\Transaction;
use App\Models\User;
use App\Utils\Enums\BusinessTypeEnum;
use App\Utils\Enums\SystemIncomeCategoryEnum;
use App\Utils\Enums\SystemIncomeStatusEnum;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionsFactory extends Factory
{
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $businessCode = Business::where('type',BusinessTypeEnum::AGENCY->value)->first()->code;
        $locations = Location::where('business_code',$businessCode)->get('code')->toArray();
        $user = User::where('business_code',$businessCode)->first();

        return [
            'business_code' => $businessCode,
            'location_code' => fake()->randomElement($locations)['code'],
            'user_code' => $user->code,
            'type' => fake()->randomElement(TransactionTypeEnum::class),
            'category' => fake()->randomElement(TransactionCategoryEnum::class),
            'amount' => fake()->numberBetween(5000, 25000),
            'amount_currency' => fake()->randomElement(['kes','tzs']),
            'balance_old' => fake()->numberBetween(40000, 100000),
            'balance_new' => fake()->numberBetween(100000, 500000),
            'description' => fake()->sentence,
        ];
    }
}

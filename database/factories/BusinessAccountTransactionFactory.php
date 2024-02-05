<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Location;
use App\Models\User;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BusinessAccountTransaction>
 */
class BusinessAccountTransactionFactory extends Factory
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
        if(empty($businesses)){
            $businessCode = Business::factory()->create()->code;
        }else{
            $businessCode = fake()->randomElement($businesses)['code'];
        }

        return [
            'business_code' => $businessCode,
            'type' => fake()->randomElement(TransactionTypeEnum::class),
            'category' => fake()->randomElement(TransactionCategoryEnum::class),
            'amount' => fake()->numberBetween(5000, 25000),
            'amount_currency' => 'tzs',
            'balance_old' => fake()->numberBetween(40000, 100000),
            'balance_new' => fake()->numberBetween(100000, 500000),
            'description' => fake()->sentence,
        ];
    }
}

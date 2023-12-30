<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Country;
use App\Models\ExchangeAds;
use App\Models\ExchangeTransaction;
use App\Models\FinancialServiceProvider;
use App\Models\Transaction;
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
        $transactions = ExchangeTransaction::get('id')->toArray();
        $transactionId = null;
        if(empty($transactions)){
            $transactionId = ExchangeTransaction::factory()->create()->id;
        }else{
            $transactionId = fake()->randomElement($transactions)['id'];
        }

        $exchangeTransaction = ExchangeTransaction::where('id',$transactionId)->first();
        $users = User::where('business_code',$exchangeTransaction->owner_business_code)->get('code')->toArray();
        $userCode = null;
        if(empty($users)){
            $userCode = User::factory()->create(['business_code'=>$exchangeTransaction->owner_business_code])->code;
        }else{
            $userCode = fake()->randomElement($users)['code'];
        }

        return [
            'exchange_trnx_id' => $transactionId,
            'sender_code' => $userCode,
            'message' => fake()->sentence,
        ];
    }
}

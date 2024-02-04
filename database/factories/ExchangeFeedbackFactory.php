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
        $transactions = ExchangeTransaction::get('id')->toArray();
        $transactionId = null;
        if(empty($transactions)){
            $transactionId = ExchangeTransaction::factory()->create()->id;
        }else{
            $transactionId = fake()->randomElement($transactions)['id'];
        }

        $exchangeTransaction = ExchangeTransaction::where('id',$transactionId)->first();
        $reviewedBusinessCode = fake()->randomElement([$exchangeTransaction->owner_business_code,$exchangeTransaction->trader_business_code]);

        $users = User::where('business_code',$reviewedBusinessCode)->get(['code'])->toArray();
        if(empty($users)){
            $userCode = User::factory()->create(['business_code'=>$reviewedBusinessCode])->code;
        }else{
            $userCode = fake()->randomElement($users)['code'];
        }


        return [
            'exchange_trnx_id' => $transactionId,
            'reviewed_business_code' => $reviewedBusinessCode,
            'review' => fake()->randomElement([0,1]),
            'review_comment' => fake()->sentence,
            'reviewer_user_code' => $userCode,
        ];
    }
}

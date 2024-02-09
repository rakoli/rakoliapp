<?php

namespace Tests\Unit;

use App\Actions\CompleteInitiatedPayment;
use App\Actions\InitiateSubscriptionPayment;
use App\Models\Business;
use App\Models\InitiatedPayment;
use App\Models\Package;
use App\Models\User;
use App\Utils\Enums\InitiatedPaymentStatusEnum;
use App\Utils\Enums\SystemIncomeCategoryEnum;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActionsTest extends TestCase
{
    //    use RefreshDatabase;

    /** @test */
    public function can_initiate_subscription_payment()
    {
        $paymentMethod = 'test';
        $package = Package::factory()->create();
        Business::factory()->create(); //to be used in user factory as available business
        $user = User::factory()->create();

        $requestResult = InitiateSubscriptionPayment::run($paymentMethod, $user, $package);

        $this->assertNotFalse($requestResult['success']);
        $this->assertDatabaseHas('initiated_payments', [
            'business_code' => $user->business_code,
        ]);
    }

    /** @test */
    public function can_complete_initiated_subscription_payment_and_record_system_income()
    {
        $user = User::factory()->create();

        $initiedPayment = InitiatedPayment::factory()->create(['business_code' => $user->business_code]);
        CompleteInitiatedPayment::run($initiedPayment);

        $this->assertDatabaseHas('initiated_payments', [
            'business_code' => $user->business_code,
            'status' => InitiatedPaymentStatusEnum::COMPLETED,
        ]);

        $this->assertDatabaseHas('system_incomes', [
            'channel_reference' => $initiedPayment->code,
        ]);

    }

    /** @test */
    public function can_complete_initiated_subscription_payment_and_pay_referral_commission()
    {
        $uplineBusiness = Business::factory()->create();
        User::factory()->create(['business_code' => $uplineBusiness->code, 'registration_step' => 2]); //For complete payment to work

        $business = Business::factory()->create();
        $user = User::factory()->create(['referral_business_code' => $uplineBusiness->code, 'business_code' => $business->code]);

        $package = Package::factory()->create();
        $initiedPayment = InitiatedPayment::factory()->create([
            'business_code' => $user->business_code,
            'description' => $package->code,
            'income_category' => SystemIncomeCategoryEnum::SUBSCRIPTION->value,
        ]);

        CompleteInitiatedPayment::run($initiedPayment);

        $this->assertDatabaseHas('business_account_transactions', [
            'business_code' => $uplineBusiness->code,
            'type' => TransactionTypeEnum::MONEY_IN->value,
            'category' => TransactionCategoryEnum::INCOME->value,
            'amount' => $package->price_commission,
            'balance_old' => 0,
            'balance_new' => $package->price_commission,
        ]);

        $businessAfter = Business::where('id', $uplineBusiness->id)->first();
        $this->assertEquals($package->price_commission, $businessAfter->balance);

    }
}

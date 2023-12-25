<?php

namespace Tests\Unit;

use App\Actions\CompleteInitiatedPayment;
use App\Actions\InitiateSubscriptionPayment;
use App\Models\Business;
use App\Models\InitiatedPayment;
use App\Models\Package;
use App\Models\User;
use App\Utils\Enums\InitiatedPaymentStatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpOffice\PhpSpreadsheet\Calculation\Engineering\Complex;
use Tests\TestCase;

class ActionsTest extends TestCase
{
//    use RefreshDatabase;

    /** @test */
    public function can_initiate_subscription_payment()
    {
        $paymentMethod = 'test';
        $package = Package::factory()->create();
        Business::factory()->create();//to be used in user factory as available business
        $user = User::factory()->create();

        $requestResult = InitiateSubscriptionPayment::run($paymentMethod,$user,$package);

        $this->assertNotFalse($requestResult['success']);
        $this->assertDatabaseHas('initiated_payments', [
            'business_code' => $user->business_code,
        ]);
    }

    /** @test */
    public function can_complete_initiated_subscription_payment_and_record_system_income()
    {
        $user = User::factory()->create();

        $initiedPayment = InitiatedPayment::factory()->create(['business_code'=>$user->business_code]);
        CompleteInitiatedPayment::run($initiedPayment);

        $this->assertDatabaseHas('initiated_payments', [
            'business_code' => $user->business_code,
            'status' => InitiatedPaymentStatusEnum::COMPLETED,
        ]);

        $this->assertDatabaseHas('system_incomes', [
            'channel_reference' => $initiedPayment->code,
        ]);

    }


}

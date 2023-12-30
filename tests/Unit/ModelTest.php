<?php

namespace Tests\Unit;

use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\ExchangeBusinessMethod;
use App\Models\ExchangeFeedback;
use App\Models\ExchangePaymentMethod;
use App\Models\ExchangeStat;
use App\Models\ExchangeTransaction;
use App\Models\InitiatedPayment;
use App\Models\Location;
use App\Models\Network;
use App\Models\User;
use App\Utils\Enums\BusinessStatusEnum;
use App\Utils\Enums\ExchangePaymentMethodTypeEnum;
use App\Utils\Enums\ExchangeStatusEnum;
use App\Utils\Enums\ExchangeTransactionStatusEnum;
use App\Utils\Enums\InitiatedPaymentStatusEnum;
use App\Utils\Enums\UserTypeEnum;
use Database\Factories\ExchangeFeedbackFactory;
use Database\Seeders\CountrySeeder;
use Database\Seeders\TZFSPSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class ModelTest extends TestCase
{
    use WithFaker;

    protected $seeder = CountrySeeder::class;

    /** @test */
    public function can_add_business_with_defaults()
    {
        // Arrange
        $name = fake()->company;
        $data = [
            'country_code' => "TZ",
            'type' => UserTypeEnum::AGENT->value,
            'code'=> generateCode($name),
            'business_name' => $name,
        ];

        // Act
        $business = Business::addBusiness($data);

        // Assert
        if ($business === false) {
            $this->fail('Failed to create a business.');
        }

        $this->assertInstanceOf(Business::class, $business);

        $this->assertDatabaseHas('locations', [
            'business_code' => $business->code,
        ]);

        $this->assertDatabaseHas('exchange_business_methods', [
            'business_code' => $business->code,
        ]);
    }

    /** @test */
    public function exchangead_can_check_allowed_user()
    {

        $name = fake()->company;
        $data = [
            'country_code' => "TZ",
            'type' => UserTypeEnum::AGENT->value,
            'code'=> generateCode($name),
            'business_name' => $name,
        ];

        $business = Business::addBusiness($data);

        $exchangeAd = ExchangeAds::factory()->create(['business_code'=>$business->code]);

        $user = User::factory()->create(['business_code'=>$business->code]);

        $failUser = User::factory()->create(['business_code'=>null]);

        $this->assertTrue($exchangeAd->isUserAllowed($user));
        $this->assertFalse($exchangeAd->isUserAllowed($failUser));
    }

    /** @test */
    public function exchange_business_methods_can_check_allowed_user()
    {

        $name = fake()->company;
        $data = [
            'country_code' => "TZ",
            'type' => UserTypeEnum::AGENT->value,
            'code'=> generateCode($name),
            'business_name' => $name,
        ];

        $business = Business::addBusiness($data);

        $exchangeAd = ExchangeBusinessMethod::factory()->create(['business_code'=>$business->code]);

        $user = User::factory()->create(['business_code'=>$business->code]);

        $failUser = User::factory()->create(['business_code'=>null]);

        $this->assertTrue($exchangeAd->isUserAllowed($user));
        $this->assertFalse($exchangeAd->isUserAllowed($failUser));
    }

    /** @test */
    public function cash_is_on_exchange_accepted_payment_methods()
    {
        $exchangeAcceptedMethods = ExchangePaymentMethod::getAcceptedList('TZ');

        $this->assertContains(["name"=>"CASH",'code'=>'CASH'],$exchangeAcceptedMethods);
    }

    /** @test */
    public function exchange_feedback_and_completion_are_autoupdated_and_returns_correct_values()
    {
        $name = fake()->company;
        $data = [
            'country_code' => "TZ",
            'type' => UserTypeEnum::AGENT->value,
            'code'=> generateCode($name),
            'business_name' => $name,
        ];

        $business = Business::addBusiness($data);

        $stat = ExchangeStat::where('business_code',$business->code)->first(); //Auto added when adding a business

        $this->assertDatabaseHas('exchange_stats', [
            'business_code' => $business->code,
            'no_of_trades_completed' => 0,
            'no_of_trades_cancelled' => 0,
            'no_of_positive_feedback' => 0,
            'no_of_negative_feedback' => 0,
            'volume_traded' => 0,
            'completion' => 0,
            'feedback' => 0,
        ]);

        $stat->no_of_trades_cancelled = 2;
        $stat->no_of_trades_completed = 98;
        $stat->save();

        $this->assertDatabaseHas('exchange_stats', [
            'business_code' => $business->code,
            'completion' => 0.98,
        ]);

        $stat->no_of_negative_feedback = 2;
        $stat->no_of_positive_feedback = 98;
        $stat->save();

        $this->assertDatabaseHas('exchange_stats', [
            'business_code' => $business->code,
            'feedback' => 0.98,
        ]);

    }

    /** @test */
    public function exchange_transaction_completion_and_cancel_statistics_updates_correctly()
    {

        $name = fake()->company;
        $data = [
            'country_code' => "TZ",
            'type' => UserTypeEnum::AGENT->value,
            'code'=> generateCode($name),
            'business_name' => $name,
        ];
        $business = Business::addBusiness($data);

        $tradeName = fake()->company;
        $traderData = [
            'country_code' => "TZ",
            'type' => UserTypeEnum::AGENT->value,
            'code'=> generateCode($tradeName),
            'business_name' => $tradeName,
        ];
        $traderBusiness = Business::addBusiness($traderData);

        $exchangeAd = ExchangeAds::factory()->has(ExchangePaymentMethod::factory(),'exchange_payment_methods')->create(['business_code'=>$business->code]);
        $exchangeTransaction = ExchangeTransaction::factory()->create([
            'exchange_ads_code'=>$exchangeAd->code,
            'owner_business_code'=>$business->code,
            'trader_business_code'=>$traderBusiness->code,
            'amount'=> 1000,
            'trader_target_method'=> 'cash',
        ]);
        $exchangeTransaction->status = ExchangeTransactionStatusEnum::COMPLETED->value;
        $exchangeTransaction->save();

        $this->assertDatabaseHas('exchange_stats', [
            'business_code' => $business->code,
            'no_of_trades_completed' => 1,
            'volume_traded' => 1000,
        ]);//Updates owner stats on complete

        $this->assertDatabaseHas('exchange_stats', [
            'business_code' => $traderBusiness->code,
            'no_of_trades_completed' => 1,
            'volume_traded' => 1000,
        ]);//Updates trader stats on complete


        $cancellingUser = User::factory()->create(['business_code'=>$traderBusiness->code]);
        $exchangeTransaction->cancelled_by_user_code = $cancellingUser->code;
        $exchangeTransaction->status = ExchangeTransactionStatusEnum::CANCELLED->value;
        $exchangeTransaction->save();
        $this->assertDatabaseHas('exchange_stats', [
            'business_code' => $traderBusiness->code,
            'no_of_trades_cancelled' => 1,
        ]);//Updates business stats on cancel trade

    }

    /** @test */
    public function exchange_transaction_feedback_statistics_updates_correctly()
    {

        $name = fake()->company;
        $data = [
            'country_code' => "TZ",
            'type' => UserTypeEnum::AGENT->value,
            'code'=> generateCode($name),
            'business_name' => $name,
        ];
        $business = Business::addBusiness($data);
        User::factory()->create();//To have a fresh user on db to be used on feedback seeder

        $tradeName = fake()->company;
        $traderData = [
            'country_code' => "TZ",
            'type' => UserTypeEnum::AGENT->value,
            'code'=> generateCode($tradeName),
            'business_name' => $tradeName,
        ];
        $traderBusiness = Business::addBusiness($traderData);

        $exchangeAd = ExchangeAds::factory()->has(ExchangePaymentMethod::factory(),'exchange_payment_methods')->create(['business_code'=>$business->code]);
        $exchangeTransaction = ExchangeTransaction::factory()->create([
            'exchange_ads_code'=>$exchangeAd->code,
            'owner_business_code'=>$business->code,
            'trader_business_code'=>$traderBusiness->code,
        ]);

        //Owner Positive Feedback
        $ownerPositiveFeedbackReceived = ExchangeFeedback::factory()->create([
            'exchange_trnx_id' => $exchangeTransaction->id,
            'reviewed_business_code' => $business->code, //Owner reviewed
            'review' => 1,
        ]);
        $exchangeTransaction->trader_submitted_feedback = 1;
        $exchangeTransaction->save();
        $this->assertDatabaseHas('exchange_stats', [
            'business_code' => $business->code,
            'no_of_positive_feedback' => 1,
        ]);
        $ownerPositiveFeedbackReceived->delete();

        //Owner Negative Feedback
        $ownerNegativeFeedbackReceived = ExchangeFeedback::factory()->create([
            'exchange_trnx_id' => $exchangeTransaction->id,
            'reviewed_business_code' => $business->code, //Owner reviewed
            'review' => 0,
        ]);
        $exchangeTransaction->trader_submitted_feedback = 1;
        $exchangeTransaction->save();
        $this->assertDatabaseHas('exchange_stats', [
            'business_code' => $business->code,
            'no_of_negative_feedback' => 0,
        ]);
        $ownerNegativeFeedbackReceived->delete();

        //Trader Positive Feedback
        $traderPositiveFeedbackReceived = ExchangeFeedback::factory()->create([
            'exchange_trnx_id' => $exchangeTransaction->id,
            'reviewed_business_code' => $traderBusiness->code, //Owner reviewed
            'review' => 1,
        ]);
        $exchangeTransaction->owner_submitted_feedback = 1;
        $exchangeTransaction->save();
        $this->assertDatabaseHas('exchange_stats', [
            'business_code' => $traderBusiness->code,
            'no_of_positive_feedback' => 1,
        ]);
        $traderPositiveFeedbackReceived->delete();

        //Trader Negative Feedback
        $traderNegativeFeedbackReceived = ExchangeFeedback::factory()->create([
            'exchange_trnx_id' => $exchangeTransaction->id,
            'reviewed_business_code' => $traderBusiness->code, //Owner reviewed
            'review' => 0,
        ]);
        $exchangeTransaction->owner_submitted_feedback = 1;
        $exchangeTransaction->save();
        $this->assertDatabaseHas('exchange_stats', [
            'business_code' => $traderBusiness->code,
            'no_of_negative_feedback' => 0,
        ]);
        $traderNegativeFeedbackReceived->delete();

    }

    /** @test */
    public function exchange_transaction_can_check_allowed_user()
    {

        $name = fake()->company;
        $data = [
            'country_code' => "TZ",
            'type' => UserTypeEnum::AGENT->value,
            'code'=> generateCode($name),
            'business_name' => $name,
        ];
        $ownerBusiness = Business::addBusiness($data);
        $ownerUser = User::factory()->create(['business_code'=>$ownerBusiness->code]);

        $name = fake()->company;
        $data = [
            'country_code' => "TZ",
            'type' => UserTypeEnum::AGENT->value,
            'code'=> generateCode($name),
            'business_name' => $name,
        ];
        $traderBusiness = Business::addBusiness($data);
        $traderUser = User::factory()->create(['business_code'=>$traderBusiness->code]);

        $failUser = User::factory()->create(['business_code'=>null]);

        $exchangeAd = ExchangeAds::factory()->has(ExchangePaymentMethod::factory(),'exchange_payment_methods')->create(['business_code'=>$ownerBusiness->code]);
        $exchangeTransaction = ExchangeTransaction::factory()->create([
            'exchange_ads_code'=>$exchangeAd->code,
            'owner_business_code'=>$ownerBusiness->code,
            'trader_business_code'=>$traderBusiness->code,
        ]);

        //checking
        $this->assertTrue($exchangeTransaction->isUserAllowed($ownerUser));
        $this->assertTrue($exchangeTransaction->isUserAllowed($traderUser));
        $this->assertFalse($exchangeTransaction->isUserAllowed($failUser));

    }

    /** @test */
    public function can_check_and_retrieve_business_pending_system_payments()
    {
        $name = fake()->company;
        $data = [
            'country_code' => "TZ",
            'type' => UserTypeEnum::AGENT->value,
            'code'=> generateCode($name),
            'business_name' => $name,
        ];
        $business = Business::addBusiness($data);
        $user = User::factory()->create(['business_code'=>$business->code]);

        InitiatedPayment::factory()->create([
            'business_code'=>$business->code,
            'status'=>InitiatedPaymentStatusEnum::INITIATED->value,
        ]);

        $this->assertTrue($user->hasPendingPayment());

        $pendingPayment = $user->getBusinessPendingPayments(['business_code','status'])->toArray();

        $this->assertContains([
            'business_code'=>$business->code,
            'status'=>InitiatedPaymentStatusEnum::INITIATED->value,
        ],$pendingPayment);

    }

    /** @test */
    public function softs_deletes_business()
    {
        $business = Business::factory()->create();
        $code = $business->code;

        $business->delete();

        $this->assertDatabaseHas('businesses',[
            'code' => $code
        ]);
        $this->assertNotNull($business->deleted_at);
        $this->assertNotContains(['code'=>$code], Business::get()->toArray());

    }

    /** @test */
    public function softs_deletes_business_networks()
    {
        $networkTill = Network::factory()->create();
        $code = $networkTill->code;

        $networkTill->delete();

        $this->assertDatabaseHas('networks',[
            'code' => $code
        ]);
        $this->assertNotNull($networkTill->deleted_at);
        $this->assertNotContains(['code'=>$code], Network::get()->toArray());

    }

}

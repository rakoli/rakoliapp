<?php

namespace Tests\Feature;

use App\Models\Business;
use App\Models\ExchangeTransaction;
use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Models\Transaction;
use App\Models\User;
use App\Models\VasContract;
use App\Utils\Enums\BusinessTypeEnum;
use App\Utils\Enums\ExchangeTransactionStatusEnum;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\UserTypeEnum;
use App\Utils\StatisticsService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    /** @test */
    public function agent_dashboard_number_of_network_tills()
    {
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'business_code'=>Business::factory()->create()->code,
        ]);
        $this->actingAs($user);

        $noOfTills = 5;
        Network::factory()->count(2)->create();//To validate it is true
        Network::factory()->count($noOfTills)->create(['business_code'=>$user->business_code]);

        $stats = new StatisticsService($user);
        $this->assertEquals($noOfTills,$stats->noOfBusinessNetworks());

    }

    /** @test */
    public function agent_dashboard_number_of_open_shifts()
    {
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'business_code'=>Business::factory()->create()->code,
        ]);
        $this->actingAs($user);

        $noOfOpenShifts = 5;
        Shift::factory()->count(2)->create(['business_code'=>$user->business_code,'status'=>ShiftStatusEnum::CLOSED]);//To validate it is true
        Shift::factory()->count($noOfOpenShifts)->create(['business_code'=>$user->business_code,'status'=>ShiftStatusEnum::OPEN]);

        $stats = new StatisticsService($user);
        $this->assertEquals($noOfOpenShifts,$stats->noOfBusinessOpenShifts());
    }

    /** @test */
    public function agent_dashboard_business_total_cash_balance()
    {
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'business_code'=>Business::factory()->create()->code,
        ]);
        $this->actingAs($user);

        $totalCashBalance = 30000;//10000*3
        Location::factory()->count(3)->create(['business_code'=>$user->business_code,'balance'=>10000]);

        $stats = new StatisticsService($user);
        $this->assertEquals($totalCashBalance,$stats->businessTotalCashBalance());
    }

    /** @test */
    public function agent_dashboard_business_total_tills_balance()
    {
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'business_code'=>Business::factory()->create()->code,
        ]);
        $this->actingAs($user);

        $totalTillBalance = 40000;//10000*4

        Network::factory()->count(4)->create(['business_code'=>$user->business_code,'balance'=>10000]);

        $stats = new StatisticsService($user);
        $this->assertEquals($totalTillBalance,$stats->businessTotalTillBalance());
    }

    /** @test */
    public function agent_dashboard_business_awarded_vas_contract()
    {
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'business_code'=>Business::factory()->create()->code,
        ]);
        $this->actingAs($user);

        $awardedVASContract = 3;

        VasContract::factory()->count($awardedVASContract)->create(['agent_business_code'=>$user->business_code]);


        $stats = new StatisticsService($user);
        $this->assertEquals($awardedVASContract,$stats->agentNoOfAwardedVasContract());
    }

    /** @test */
    public function business_no_of_pending_exchanges()
    {
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'business_code'=>Business::factory()->create()->code,
        ]);
        $this->actingAs($user);

        $traderOpenedExchanges = 3;
        $ownerOpenedExchanges = 4;

        ExchangeTransaction::factory()->count($traderOpenedExchanges)->create(['trader_business_code'=>$user->business_code, 'status' => ExchangeTransactionStatusEnum::OPEN]);
        ExchangeTransaction::factory()->count($ownerOpenedExchanges)->create(['owner_business_code'=>$user->business_code,'status' => ExchangeTransactionStatusEnum::OPEN]);


        $stats = new StatisticsService($user);
        $this->assertEquals(($traderOpenedExchanges + $ownerOpenedExchanges),$stats->agentNoOfPendingExchange());
    }

    /** @test */
    public function business_30_days_income()
    {
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'business_code'=>Business::factory()->create()->code,
        ]);
        $this->actingAs($user);

        $total30DaysIncome = 100000;//25000*4
        Transaction::factory()->count(4)->create([
            'business_code' => $user->business_code,
            'category' => TransactionCategoryEnum::INCOME,
            'amount'=>25000
        ]);
        Transaction::factory()->create([
            'business_code' => $user->business_code,
            'category' => TransactionCategoryEnum::INCOME,
            'amount'=>20000,
            'created_at'=> Carbon::now()->subDays(31)
        ]);


        $stats = new StatisticsService($user);
        $this->assertEquals($total30DaysIncome,$stats->businessIncomeTotalof30days());
    }

    /** @test */
    public function business_30_days_expense()
    {
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'business_code'=>Business::factory()->create()->code,
        ]);
        $this->actingAs($user);

        $total30DaysExpense = 125000;//25000*5
        Transaction::factory()->count(5)->create([
            'business_code' => $user->business_code,
            'category' => TransactionCategoryEnum::EXPENSE,
            'amount'=>25000
        ]);
        Transaction::factory()->create([
            'business_code' => $user->business_code,
            'category' => TransactionCategoryEnum::EXPENSE,
            'amount'=>20000,
            'created_at'=> Carbon::now()->subDays(31)
        ]);

        $stats = new StatisticsService($user);
        $this->assertEquals($total30DaysExpense,$stats->businessExpenseTotalof30days());
    }

    /** @test */
    public function business_no_of_referrals()
    {
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'business_code'=>Business::factory()->create()->code,
        ]);
        $this->actingAs($user);

        $noOfReferrals = 3;
        Business::factory()->count($noOfReferrals)->create([
            'type'=>BusinessTypeEnum::AGENCY->value,
            'referral_business_code'=> $user->business_code,
        ]);

        $stats = new StatisticsService($user);
        $this->assertEquals($noOfReferrals,$stats->businessNoOfReferrals());
    }

}

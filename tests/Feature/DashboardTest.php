<?php

namespace Tests\Feature;

use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\ExchangeTransaction;
use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Models\SystemIncome;
use App\Models\Transaction;
use App\Models\User;
use App\Models\VasContract;
use App\Models\VasPayment;
use App\Models\VasSubmission;
use App\Models\VasTask;
use App\Utils\Enums\BusinessTypeEnum;
use App\Utils\Enums\ExchangeStatusEnum;
use App\Utils\Enums\ExchangeTransactionStatusEnum;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\UserTypeEnum;
use App\Utils\Enums\VasTaskStatusEnum;
use App\Utils\StatisticsService;
use Carbon\Carbon;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    /** @test */
    public function agent_dashboard_number_of_network_tills()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::AGENT->value,
            'business_code' => Business::factory()->create()->code,
        ]);

        $noOfTills = 5;
        Network::factory()->count(2)->create(['business_code' => Business::factory()->create()->code]); //To validate it is true
        Network::factory()->count($noOfTills)->create(['business_code' => $user->business_code]);

        $stats = new StatisticsService($user);
        $this->assertEquals($noOfTills, $stats->noOfBusinessNetworks());

    }

    /** @test */
    public function agent_dashboard_number_of_open_shifts()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::AGENT->value,
            'business_code' => Business::factory()->create()->code,
        ]);

        $noOfOpenShifts = 5;
        Shift::factory()->count(2)->create(['business_code' => $user->business_code, 'status' => ShiftStatusEnum::CLOSED]); //To validate it is true
        Shift::factory()->count($noOfOpenShifts)->create(['business_code' => $user->business_code, 'status' => ShiftStatusEnum::OPEN]);

        $stats = new StatisticsService($user);
        $this->assertEquals($noOfOpenShifts, $stats->noOfBusinessOpenShifts());
    }

    /** @test */
    public function agent_dashboard_business_total_cash_balance()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::AGENT->value,
            'business_code' => Business::factory()->create()->code,
        ]);

        $totalCashBalance = 30000; //10000*3
        Location::factory()->count(3)->create(['business_code' => $user->business_code, 'balance' => 10000]);

        $stats = new StatisticsService($user);
        $this->assertEquals($totalCashBalance, $stats->businessTotalCashBalance());
    }

    /** @test */
    public function agent_dashboard_business_total_tills_balance()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::AGENT->value,
            'business_code' => Business::factory()->create()->code,
        ]);

        $totalTillBalance = 40000; //10000*4

        Network::factory()->count(4)->create(['business_code' => $user->business_code, 'balance' => 10000]);

        $stats = new StatisticsService($user);
        $this->assertEquals($totalTillBalance, $stats->businessTotalTillBalance());
    }

    /** @test */
    public function agent_dashboard_business_awarded_vas_contract()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::AGENT->value,
            'business_code' => Business::factory()->create()->code,
        ]);

        $awardedVASContract = 3;

        VasContract::factory()->count($awardedVASContract)->create(['agent_business_code' => $user->business_code]);

        $stats = new StatisticsService($user);
        $this->assertEquals($awardedVASContract, $stats->agentNoOfAwardedVasContract());
    }

    /** @test */
    public function business_no_of_pending_exchanges()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::AGENT->value,
            'business_code' => Business::factory()->create()->code,
        ]);
        $this->actingAs($user); //Auth->User is needed on StatisticsService

        $traderOpenedExchanges = 3;
        $ownerOpenedExchanges = 4;

        ExchangeTransaction::factory()->count($traderOpenedExchanges)->create(['trader_business_code' => $user->business_code, 'status' => ExchangeTransactionStatusEnum::OPEN]);
        ExchangeTransaction::factory()->count($ownerOpenedExchanges)->create(['owner_business_code' => $user->business_code, 'status' => ExchangeTransactionStatusEnum::OPEN]);

        $stats = new StatisticsService($user);
        $this->assertEquals(($traderOpenedExchanges + $ownerOpenedExchanges), $stats->agentNoOfPendingExchange());
    }

    /** @test */
    public function business_30_days_income()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::AGENT->value,
            'business_code' => Business::factory()->create()->code,
        ]);

        $total30DaysIncome = 100000; //25000*4
        Transaction::factory()->count(4)->create([
            'business_code' => $user->business_code,
            'category' => TransactionCategoryEnum::INCOME,
            'amount' => 25000,
        ]);
        Transaction::factory()->create([
            'business_code' => $user->business_code,
            'category' => TransactionCategoryEnum::INCOME,
            'amount' => 20000,
            'created_at' => Carbon::now()->subDays(31),
        ]);

        $stats = new StatisticsService($user);
        $this->assertEquals($total30DaysIncome, $stats->businessIncomeTotalof30days());
    }

    /** @test */
    public function business_30_days_expense()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::AGENT->value,
            'business_code' => Business::factory()->create()->code,
        ]);

        $total30DaysExpense = 125000; //25000*5
        Transaction::factory()->count(5)->create([
            'business_code' => $user->business_code,
            'category' => TransactionCategoryEnum::EXPENSE,
            'amount' => 25000,
        ]);
        Transaction::factory()->create([
            'business_code' => $user->business_code,
            'category' => TransactionCategoryEnum::EXPENSE,
            'amount' => 20000,
            'created_at' => Carbon::now()->subDays(31),
        ]);

        $stats = new StatisticsService($user);
        $this->assertEquals($total30DaysExpense, $stats->businessExpenseTotalof30days());
    }

    /** @test */
    public function business_no_of_referrals()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::AGENT->value,
            'business_code' => Business::factory()->create()->code,
        ]);

        $noOfReferrals = 3;
        Business::factory()->count($noOfReferrals)->create([
            'type' => BusinessTypeEnum::AGENCY->value,
            'referral_business_code' => $user->business_code,
        ]);

        $stats = new StatisticsService($user);
        $this->assertEquals($noOfReferrals, $stats->businessNoOfReferrals());
    }

    /** @test */
    public function vas_total_no_of_services_tasks_posted()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::VAS->value,
            'business_code' => Business::factory()->create()->code,
        ]);

        $noOfServices = 3;
        VasTask::factory()->count($noOfServices)->create([
            'vas_business_code' => $user->business_code,
        ]);

        $stats = new StatisticsService($user);
        $this->assertEquals($noOfServices, $stats->vas_total_services_posted());
    }

    /** @test */
    public function vas_total_no_of_received_submission()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::VAS->value,
            'business_code' => Business::factory()->create()->code,
        ]);

        $noOfSubmissions = 4;
        $vasContract = VasContract::factory()->create(['vas_business_code' => $user->business_code]);
        VasSubmission::factory()->count($noOfSubmissions)->create([
            'vas_contract_code' => $vasContract->code,
        ]);

        $stats = new StatisticsService($user);
        $this->assertEquals($noOfSubmissions, $stats->vas_total_received_submissions());
    }

    /** @test */
    public function vas_total_no_of_users_in_business()
    {
        $noOfVasBusinessUsers = 3;
        $business = Business::factory()->create(['type' => BusinessTypeEnum::VAS]);
        $user = User::factory()->count($noOfVasBusinessUsers)->create([
            'type' => UserTypeEnum::VAS->value,
            'business_code' => $business->code,
        ]);

        $stats = new StatisticsService($user->first());
        $this->assertEquals($noOfVasBusinessUsers, $stats->vas_no_of_users_in_business(), 'no of users in the business');
    }

    /** @test */
    public function vas_total_payment_made_to_contractors()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::VAS->value,
            'business_code' => Business::factory()->create()->code,
        ]);

        $totalVasPayments = 100000; //20000*5
        VasPayment::factory()->count(5)->create([
            'business_code' => $user->business_code,
            'amount' => 20000,
        ]);

        $stats = new StatisticsService($user);
        $this->assertEquals($totalVasPayments, $stats->vas_total_payments_made());
    }

    /** @test */
    public function admin_total_no_of_business_in_system()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::ADMIN->value,
        ]);
        $noOfBusiness = Business::get()->count();

        $stats = new StatisticsService($user);
        $this->assertEquals($noOfBusiness, $stats->admin_total_no_of_businesses());
    }

    /** @test */
    public function admin_total_system_income()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::ADMIN->value,
        ]);
        $totalSystemIncome = SystemIncome::where('status', \App\Utils\Enums\SystemIncomeStatusEnum::RECEIVED->value)->get()->sum('amount');

        $stats = new StatisticsService($user);
        $this->assertEquals($totalSystemIncome, $stats->admin_total_system_income());
    }

    /** @test */
    public function admin_no_of_active_exchange_listing()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::ADMIN->value,
        ]);
        $data = ExchangeAds::where('status', ExchangeStatusEnum::ACTIVE->value)->count();

        $stats = new StatisticsService($user);
        $this->assertEquals($data, $stats->admin_no_of_exchange_listing());
    }

    /** @test */
    public function admin_no_of_active_vas_listing()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::ADMIN->value,
        ]);
        $data = VasTask::where('status', VasTaskStatusEnum::ACTIVE->value)->count();

        $stats = new StatisticsService($user);
        $this->assertEquals($data, $stats->admin_no_of_vas_listing());
    }

    /** @test */
    public function admin_no_business_with_active_subscription()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::ADMIN->value,
        ]);
        $data = Business::whereNotNull('package_code')->count();

        $stats = new StatisticsService($user);
        $this->assertEquals($data, $stats->admin_no_business_with_active_subscription());
    }

    /** @test */
    public function admin_no_users_in_system()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::ADMIN->value,
        ]);
        $data = User::count();

        $stats = new StatisticsService($user);
        $this->assertEquals($data, $stats->admin_no_users_in_system());
    }

    /** @test */
    public function agent_dashboard_loads_business_recent_transactions()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::AGENT->value,
            'registration_step' => 0,
            'business_code' => Business::factory()->create()->code,
        ]);

        $noOfTransactions = 5;
        $transactions = Transaction::factory()->count($noOfTransactions)->create(['business_code' => $user->business_code]);

        $this->actingAs($user);
        $response = $this->getJson(route('agent.dashboard'), ['X-Requested-With' => 'XMLHttpRequest']);
        $responseArray = json_decode($response->content(), 'true');

        $allValuesFound = true;
        $firstArray = $transactions->toArray();
        $secondArray = $responseArray['data'];
        $secondArrayIds = [];
        foreach ($secondArray as $item) {
            array_push($secondArrayIds, $item['id']);
        }
        foreach ($firstArray as $firstArrayItem) {
            if (! in_array($firstArrayItem['id'], $secondArrayIds)) {
                $allValuesFound = false;
                break; // No need to continue checking if one value is not found
            }
        }

        $this->assertTrue($allValuesFound);
        $this->assertEquals($noOfTransactions, $responseArray['recordsTotal']);
    }

    /** @test */
    public function vas_dashboard_loads_business_vas_payments()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::VAS->value,
            'registration_step' => 0,
            'business_code' => Business::factory()->create()->code,
        ]);

        $noOfPayments = 5;
        $vasContract = VasContract::factory()->create(['vas_business_code' => $user->business_code]);
        $vasPayments = VasPayment::factory()->count($noOfPayments)->create(['business_code' => $user->business_code, 'vas_contract_code' => $vasContract->code]);

        $this->actingAs($user);
        $response = $this->getJson(route('vas.dashboard'), ['X-Requested-With' => 'XMLHttpRequest']);
        $responseArray = json_decode($response->content(), 'true');

        $allValuesFound = true;
        $firstArray = $vasPayments->toArray();
        $secondArray = $responseArray['data'];
        $secondArrayIds = [];
        foreach ($secondArray as $item) {
            array_push($secondArrayIds, $item['id']);
        }
        foreach ($firstArray as $firstArrayItem) {
            if (! in_array($firstArrayItem['id'], $secondArrayIds)) {
                $allValuesFound = false;
                break; // No need to continue checking if one value is not found
            }
        }

        $this->assertTrue($allValuesFound);
        $this->assertEquals($noOfPayments, $responseArray['recordsTotal']);
    }

    /** @test */
    public function admin_dashboard_loads_recent_system_income()
    {
        $user = User::factory()->create([
            'type' => UserTypeEnum::ADMIN->value,
            'registration_step' => 0,
            'business_code' => Business::factory()->create()->code,
        ]);

        $noOfPayments = 10; //MUST BE 10 cause view loads recent 10 only
        $payments = SystemIncome::factory()->count($noOfPayments)->create();

        $this->actingAs($user);
        $response = $this->getJson(route('admin.dashboard'), ['X-Requested-With' => 'XMLHttpRequest']);
        $responseArray = json_decode($response->content(), 'true');

        $allValuesFound = true;
        $firstArray = $payments->toArray();
        $secondArray = $responseArray['data'];
        $secondArrayIds = [];
        foreach ($secondArray as $item) {
            array_push($secondArrayIds, $item['id']);
        }
        foreach ($firstArray as $firstArrayItem) {
            if (! in_array($firstArrayItem['id'], $secondArrayIds)) {
                $allValuesFound = false;
                break; // No need to continue checking if one value is not found
            }
        }

        $this->assertTrue($allValuesFound);
        $this->assertEquals($noOfPayments, $responseArray['recordsTotal']);
    }
}

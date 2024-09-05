<?php

namespace App\Utils;

use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\ExchangeTransaction;
use App\Models\Loan;
use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Models\SystemIncome;
use App\Models\Transaction;
use App\Models\User;
use App\Models\VasContract;
use App\Models\VasPayment;
use App\Models\VasTask;
use App\Utils\Enums\ExchangeStatusEnum;
use App\Utils\Enums\ExchangeTransactionStatusEnum;
use App\Utils\Enums\LoanTypeEnum;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\TransactionTypeEnum;
use App\Utils\Enums\VasTaskStatusEnum;

class StatisticsService
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function noOfBusinessNetworks()
    {
        return Network::where('business_code',$this->user->business_code)->get()->count();
    }

    public function noOfBusinessOpenShifts()
    {
        return Shift::where(['status'=>ShiftStatusEnum::OPEN,'business_code'=>$this->user->business_code])->get()->count();
    }

    public function businessTotalCashBalance()
    {
        return Location::where('business_code',$this->user->business_code)->get()->sum('balance');
    }

    public function businessTotalTillBalance()
    {
        return Network::where('business_code',$this->user->business_code)->get()->sum('balance');
    }

    public function businessTotalLoanBalance()
    {
        return Loan::where('business_code',$this->user->business_code)->get()->sum('balance');
    }
    
    public function locationTotalCreditLoan($location_code)
    {
        return Loan::where('location_code',$location_code)->where('type',LoanTypeEnum::MONEY_IN)->get()->sum('balance');
    }

    public function locationTotalDebitLoan($location_code)
    {
        return Loan::where('location_code',$location_code)->where('type',LoanTypeEnum::MONEY_OUT)->get()->sum('balance');
    }

    public function agentNoOfAwardedVasContract()
    {
        return VasContract::where('agent_business_code', $this->user->business_code)->get()->count();
    }

    public function agentNoOfPendingExchange()
    {
        return ExchangeTransaction::where([
            'trader_business_code' => $this->user->business_code,
            'status' => ExchangeTransactionStatusEnum::OPEN
        ])->orWhere(function (\Illuminate\Database\Eloquent\Builder $query) {
            $query->where('owner_business_code', auth()->user()->business_code)
                ->where('status', ExchangeTransactionStatusEnum::OPEN);
        })->get()->count();
    }

    public function businessIncomeTotalof30days()
    {
        return Transaction::where([
            'business_code' => $this->user->business_code,
            'category' => TransactionCategoryEnum::INCOME,
        ])->where('created_at','>=',now()->subDays(30))->get()->sum('amount');
    }

    public function businessExpenseTotalof30days()
    {
        return Transaction::where([
            'business_code' => $this->user->business_code,
            'category' => TransactionCategoryEnum::EXPENSE,
        ])->where('created_at','>=',now()->subDays(30))->get()->sum('amount');
    }

    public function businessTotalTransaction()
    {
        return Transaction::where([
            'business_code' => $this->user->business_code,
        ])->count();

    }

    public function businessTotalDepositTransaction()
    {
        return Transaction::where([
            'business_code' => $this->user->business_code,
            'type' => TransactionTypeEnum::MONEY_IN,
        ])->sum('amount');

    }

    public function businessTotalWithdrawalTransaction()
    {
        return Transaction::where([
            'business_code' => $this->user->business_code,
            'type' => TransactionTypeEnum::MONEY_OUT,
        ])->sum('amount');

    }

    public function businessNoOfReferrals()
    {
        return Business::where('referral_business_code', $this->user->business_code)->get()->count();
    }

    public function vas_total_services_posted()
    {
        return VasTask::where('vas_business_code',$this->user->business_code)->count();
    }

    public function vas_total_received_submissions()
    {
        return Business::where('code',$this->user->business_code)->first()->agentsSubmissions()->count();
    }

    public function vas_no_of_users_in_business()
    {
        return User::where('business_code',$this->user->business_code)->count();
    }

    public function vas_total_payments_made()
    {
        return VasPayment::where('business_code',$this->user->business_code)->get()->sum('amount');
    }

    public function admin_total_no_of_businesses()
    {
        return Business::get()->count();
    }

    public function admin_total_system_income()
    {
        return SystemIncome::where('status', \App\Utils\Enums\SystemIncomeStatusEnum::RECEIVED->value)->get()->sum('amount');
    }

    public function admin_no_of_exchange_listing()
    {
        return ExchangeAds::where('status',ExchangeStatusEnum::ACTIVE->value)->count();
    }

    public function admin_no_of_vas_listing()
    {
        return VasTask::where('status',VasTaskStatusEnum::ACTIVE->value)->count();
    }

    public function admin_no_business_with_active_subscription()
    {
        return Business::whereNotNull('package_code')->count();
    }

    public function admin_no_users_in_system()
    {
        return User::count();
    }

    public function agent_referrals_list()
    {
        return User::where('referral_business_code',$this->user->business_code)->get();
    }

    public function agent_total_number_of_referrals()
    {
        return $this->agent_referrals_list()->count();
    }

    public function agent_total_annual_referral_commission()
    {
        $totalCommission = 0;
        foreach ($this->agent_referrals_list() as $downline) {
            if($downline->business != null ){
                if($downline->business->package != null){
                    $totalCommission = $totalCommission + $downline->business->package->price_commission;
                }
            }
        }
        return $totalCommission;
    }

    public function agent_total_no_of_inactive_referrals()
    {
        $totalInactive = 0;
        foreach ($this->agent_referrals_list() as $downline) {
            if($downline->business != null ){
                if($downline->business->package == null){
                    $totalInactive = $totalInactive + 1;
                }
            }
        }
        return $totalInactive;
    }

    public function businessOverview()
    {
        $data['bussiness'][0]['name'] = $this->user->business->business_name;
        $data['bussiness'][0]['physical_balance'] = 0;
        $data['bussiness'][0]['credit'] = 0;
        $data['bussiness'][0]['debit'] = 0;
        $data['bussiness'][0]['total_balance'] = 0;
        $data['bussiness'][0]['capital'] = 0;
        $data['bussiness'][0]['differ'] = 0;

        foreach($this->user->business->locations as $key => $location) {
            $data['branches'][$key]['name'] = $location->name;
            $data['bussiness'][0]['physical_balance'] += $data['branches'][$key]['physical_balance'] = $location->balance + $location->networks->sum('balance');
            $data['bussiness'][0]['credit'] += $data['branches'][$key]['credit'] = $this->locationTotalCreditLoan($location->code);
            $data['bussiness'][0]['debit'] += $data['branches'][$key]['debit'] = $this->locationTotalDebitLoan($location->code);
            $data['bussiness'][0]['total_balance'] += $data['branches'][$key]['total_balance'] = $data['branches'][$key]['physical_balance'] + $data['branches'][$key]['credit'] - $data['branches'][$key]['debit'] ;
            $data['bussiness'][0]['capital'] += $data['branches'][$key]['capital'] = $location->capital;
            $data['bussiness'][0]['differ'] += $data['branches'][$key]['differ'] = $data['branches'][$key]['total_balance'] - $location->capital;
        }
        return $data;
    }

}

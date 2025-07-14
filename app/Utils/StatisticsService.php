<?php

namespace App\Utils;

use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\ExchangeTransaction;
use App\Models\Loan;
use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Models\ShiftCashTransaction;
use App\Models\ShiftTransaction;
use App\Models\SystemIncome;
use App\Models\Transaction;
use App\Models\User;
use App\Models\VasContract;
use App\Models\VasPayment;
use App\Models\VasTask;
use App\Utils\Enums\ExchangeStatusEnum;
use App\Utils\Enums\ExchangeTransactionStatusEnum;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\TransactionTypeEnum;
use App\Utils\Enums\VasTaskStatusEnum;
use App\Models\ReferralPayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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

    public function locationTotalLoanBalance($location_code)
    {
        return Loan::where('location_code',$location_code)->get()->sum('balance');
    }


    public function locationTotalCreditLoan($location_code)
    {
        return Loan::where('location_code',$location_code)->where('type',TransactionTypeEnum::MONEY_IN)->get()->sum('balance');
    }

    public function locationTotalExpense($location_code)
    {
        $openShifts =  Shift::where(['status'=>ShiftStatusEnum::OPEN,'business_code'=>$this->user->business_code])->pluck('id')->toArray();
        $cashExpense = ShiftCashTransaction::whereIn('shift_id',$openShifts)->where('location_code',$location_code)->where('type', TransactionTypeEnum::MONEY_OUT)->where('category', TransactionCategoryEnum::EXPENSE)->get()->sum('amount');
        $tillExpense = ShiftTransaction::whereIn('shift_id',$openShifts)->where('location_code',operator: $location_code)->where('type', TransactionTypeEnum::MONEY_OUT)->where('category', TransactionCategoryEnum::EXPENSE)->get()->sum('amount');
        return $cashExpense + $tillExpense;
    }

    public function locationTotalDebitLoan($location_code)
    {
        return Loan::where('location_code',$location_code)->where('type',TransactionTypeEnum::MONEY_OUT)->get()->sum('balance');
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
        $cash_income = ShiftCashTransaction::where([
            'business_code' => $this->user->business_code,
            'category' => TransactionCategoryEnum::INCOME,
        ])->where('created_at','>=',now()->subDays(30))->get()->sum('amount');

        $till_income = ShiftTransaction::where([
            'business_code' => $this->user->business_code,
            'category' => TransactionCategoryEnum::INCOME,
        ])->where('created_at','>=',now()->subDays(30))->get()->sum('amount');

        return $cash_income + $till_income;
    }

    public function businessExpenseTotalof30days()
    {
        $cash_expense = ShiftCashTransaction::where([
            'business_code' => $this->user->business_code,
            'category' => TransactionCategoryEnum::EXPENSE,
        ])->where('created_at','>=',now()->subDays(30))->get()->sum('amount');

        $till_expense = ShiftTransaction::where([
            'business_code' => $this->user->business_code,
            'category' => TransactionCategoryEnum::EXPENSE,
        ])->where('created_at','>=',now()->subDays(30))->get()->sum('amount');

        return $cash_expense + $till_expense;
    }

    public function businessTotalTransaction()
    {
        $cash_txns = ShiftCashTransaction::where([
            'business_code' => $this->user->business_code,
        ])->get()->sum('amount');

        $till_txns = ShiftTransaction::where([
            'business_code' => $this->user->business_code,
        ])->get()->sum('amount');

        return $cash_txns + $till_txns;

    }

    public function businessTotalDepositTransaction()
    {
        return ShiftTransaction::where([
            'business_code' => $this->user->business_code,
            'type' => TransactionTypeEnum::MONEY_IN,
            'category' => TransactionCategoryEnum::GENERAL,
        ])->get()->sum('amount');

    }

    public function businessTotalWithdrawalTransaction()
    {
        return ShiftTransaction::where([
            'business_code' => $this->user->business_code,
            'type' => TransactionTypeEnum::MONEY_OUT,
            'category' => TransactionCategoryEnum::GENERAL,
        ])->get()->sum('amount');
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
        if($this->user->isowner){
            $data['bussiness'][0]['name'] = $this->user->business->business_name;
            $data['bussiness'][0]['physical_balance'] = 0;
            $data['bussiness'][0]['credit'] = 0;
            $data['bussiness'][0]['debit'] = 0;
            $data['bussiness'][0]['expense'] = 0;
            $data['bussiness'][0]['total_balance'] = 0;
            $data['bussiness'][0]['capital'] = 0;
            $data['bussiness'][0]['differ'] = 0;
            foreach($this->user->locations as $key => $location) {
                $data['branches'][$key]['name'] = $location->name;
                $data['bussiness'][0]['physical_balance'] += $data['branches'][$key]['physical_balance'] = $location->balance + $location->networks->sum('balance');
                $data['bussiness'][0]['credit'] += $data['branches'][$key]['credit'] = $this->locationTotalCreditLoan($location->code);
                $data['bussiness'][0]['debit'] += $data['branches'][$key]['debit'] = $this->locationTotalDebitLoan($location->code);
                $data['bussiness'][0]['expense'] += $data['branches'][$key]['expense'] = $this->locationTotalExpense($location->code);
                $data['bussiness'][0]['total_balance'] += $data['branches'][$key]['total_balance'] = $data['branches'][$key]['physical_balance'] + ($data['branches'][$key]['credit'] - $data['branches'][$key]['debit']) + $data['branches'][$key]['expense'];
                $data['bussiness'][0]['capital'] += $data['branches'][$key]['capital'] = $location->capital;
                $data['bussiness'][0]['differ'] += $data['branches'][$key]['differ'] = $data['branches'][$key]['total_balance'] - $location->capital;
            }
        } else {
            foreach($this->user->locations as $key => $location) {
                $data['branches'][$key]['name'] = $location->name;
                $data['branches'][$key]['physical_balance'] = $location->balance + $location->networks->sum('balance');
                $data['branches'][$key]['credit'] = $this->locationTotalCreditLoan($location->code);
                $data['branches'][$key]['debit'] = $this->locationTotalDebitLoan($location->code);
                $data['branches'][$key]['expense'] = $this->locationTotalExpense($location->code);
                $data['branches'][$key]['total_balance'] = $data['branches'][$key]['physical_balance'] + ($data['branches'][$key]['credit'] - $data['branches'][$key]['debit']) + $data['branches'][$key]['expense'];
                $data['branches'][$key]['capital'] = $location->capital;
                $data['branches'][$key]['differ'] = $data['branches'][$key]['total_balance'] - $location->capital;
            }
        }
            return $data;
    }

    /**
     * Enhanced Referral Earnings Statistics
     */
    public function getRegistrationEarnings()
    {
        return $this->user->referralPayments()
            ->where('payment_type', 'registration_bonus')
            ->sum('amount');
    }

    public function getWeek1TransactionEarnings()
    {
        return $this->user->referralPayments()
            ->where('payment_type', 'transaction_bonus_week1')
            ->sum('amount');
    }

    public function getWeek2TransactionEarnings()
    {
        return $this->user->referralPayments()
            ->where('payment_type', 'transaction_bonus_week2')
            ->sum('amount');
    }

    public function getTotalUsageEarnings()
    {
        return $this->getWeek1TransactionEarnings() + $this->getWeek2TransactionEarnings();
    }

    public function getTotalReferralEarnings()
    {
        return $this->getRegistrationEarnings() + $this->getTotalUsageEarnings();
    }

    public function getPaidEarnings()
    {
        return $this->user->referralPayments()
            ->where('payment_status', 'paid')
            ->sum('amount');
    }

    public function getPendingEarnings()
    {
        return $this->user->referralPayments()
            ->where('payment_status', 'pending')
            ->sum('amount');
    }

    public function getConversionRate()
    {
        $totalReferred = $this->agent_total_number_of_referrals();
        if ($totalReferred == 0) return 0;

        $completedRegistrations = User::where('referral_business_code', $this->user->business_code)
            ->whereHas('business', function($query) {
                $query->whereNotNull('package_code');
            })
            ->count();

        return round(($completedRegistrations / $totalReferred) * 100, 1);
    }

    public function getTransactionSuccessRate()
    {
        $registeredBusinesses = User::where('referral_business_code', $this->user->business_code)
            ->whereHas('business', function($query) {
                $query->whereNotNull('package_code');
            })
            ->count();

        if ($registeredBusinesses == 0) return 0;

        $user = $this->user;
        $businessesWithBonuses = $user->referralPayments()
            ->whereIn('payment_type', ['transaction_bonus_week1', 'transaction_bonus_week2'])
            ->distinct('referral_id')
            ->count();

        return round(($businessesWithBonuses / $registeredBusinesses) * 100, 1);
    }

    public function getActiveReferrals()
    {
        $twoWeeksAgo = Carbon::now()->subWeeks(2);

        return User::where('referral_business_code', $this->user->business_code)
            ->where('created_at', '>=', $twoWeeksAgo)
            ->whereHas('business', function($query) {
                $query->whereNotNull('package_code');
            })
            ->count();
    }

    public function getRegistrationBonusCount()
    {
        return $this->user->referralPayments()
            ->where('payment_type', 'registration_bonus')
            ->count();
    }

    public function getWeek1BonusCount()
    {
        return $this->user->referralPayments()
            ->where('payment_type', 'transaction_bonus_week1')
            ->count();
    }

    public function getWeek2BonusCount()
    {
        return $this->user->referralPayments()
            ->where('payment_type', 'transaction_bonus_week2')
            ->count();
    }

    /**
     * Debug method to check referral payment data
     */
    public function debugReferralPayments()
    {
        $user = $this->user;

        return [
            'user_id' => $user->id,
            'business_code' => $user->business_code,
            'total_referral_payments' => $user->referralPayments()->count(),
            'registration_payments' => $user->referralPayments()->where('payment_type', 'registration_bonus')->count(),
            'week1_payments' => $user->referralPayments()->where('payment_type', 'transaction_bonus_week1')->count(),
            'week2_payments' => $user->referralPayments()->where('payment_type', 'transaction_bonus_week2')->count(),
            'all_payments' => $user->referralPayments()->select('id', 'referral_id', 'amount', 'payment_type', 'payment_status')->get()->toArray(),
            'total_referrals' => $this->agent_total_number_of_referrals(),
            'referrals_with_business' => User::where('referral_business_code', $user->business_code)
                ->whereHas('business', function($query) {
                    $query->whereNotNull('package_code');
                })
                ->count()
        ];
    }

    /**
     * Manually create missing referral payments for this user's referrals
     */
    public function createMissingReferralPayments()
    {
        $user = $this->user;
        $created = [];

        // Find referrals with businesses but no registration bonus
        $eligibleReferrals = User::where('referral_business_code', $user->business_code)
            ->whereHas('business', function($query) {
                $query->whereNotNull('package_code');
            })
            ->whereDoesntHave('referralPaymentsReceived', function($query) {
                $query->where('payment_type', 'registration_bonus');
            })
            ->get();

        foreach ($eligibleReferrals as $referral) {
            try {
                $payment = ReferralPayment::createRegistrationBonus($user->id, $referral->id);
                if ($payment) {
                    $created[] = [
                        'type' => 'registration_bonus',
                        'referral_id' => $referral->id,
                        'referral_name' => $referral->name,
                        'amount' => 500
                    ];
                }
            } catch (\Exception $e) {
                Log::error("Failed to create registration bonus for referral {$referral->id}: " . $e->getMessage());
            }
        }

        return $created;
    }
}

<?php

namespace App\Utils;

use App\Models\Business;
use App\Models\ExchangeTransaction;
use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Models\Transaction;
use App\Models\VasContract;
use App\Utils\Enums\ExchangeTransactionStatusEnum;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionCategoryEnum;

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

    public function businessNoOfReferrals()
    {
        return Business::where('referral_business_code', $this->user->business_code)->get()->count();
    }

}

<?php

namespace App\Models;

use App\Utils\Enums\ExchangeTransactionStatusEnum;
use App\Utils\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ExchangeTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'exchange_ads_code',
        'owner_business_code',
        'trader_business_code',
        'trader_action_type',
        'trader_target_method',
        'trader_action_via_method_id',
        'trader_action_via_method',
        'amount',
        'amount_currency',
        'status',
        'trader_comments',
    ];

    protected static function booted(): void
    {
        parent::boot();

        static::updating(function(ExchangeTransaction $exchangeTransaction) {
            if ($exchangeTransaction->isDirty('status'))
            {
                if($exchangeTransaction->status == ExchangeTransactionStatusEnum::COMPLETED->value){
                    $traderStat = ExchangeStat::where('business_code', $exchangeTransaction->trader_business_code)->first();
                    $ownerStat = ExchangeStat::where('business_code', $exchangeTransaction->owner_business_code)->first();

                    $traderStat->no_of_trades_completed = $traderStat->no_of_trades_completed + 1;
                    $traderStat->volume_traded = $traderStat->volume_traded + $exchangeTransaction->amount;
                    $traderStat->save();

                    $ownerStat->no_of_trades_completed = $ownerStat->no_of_trades_completed + 1;
                    $ownerStat->volume_traded = $ownerStat->volume_traded + $exchangeTransaction->amount;
                    $ownerStat->save();
                }

                if($exchangeTransaction->status == ExchangeTransactionStatusEnum::CANCELLED->value){
                    $user = User::where('code', $exchangeTransaction->cancelled_by_user_code)->first();

                    if($user->type == UserTypeEnum::ADMIN->value){

                        $cancellingBusinessStat = ExchangeStat::where('business_code', $exchangeTransaction->trader_business_code)->first();
                        $cancellingBusinessStat->no_of_trades_cancelled = $cancellingBusinessStat->no_of_trades_cancelled + 1;
                        $cancellingBusinessStat->save();

                        $cancellingBusinessStat = ExchangeStat::where('business_code', $exchangeTransaction->owner_business_code)->first();
                        $cancellingBusinessStat->no_of_trades_cancelled = $cancellingBusinessStat->no_of_trades_cancelled + 1;
                        $cancellingBusinessStat->save();

                    }else{
                        $cancellingBusinessStat = ExchangeStat::where('business_code', $user->business_code)->first();
                        $cancellingBusinessStat->no_of_trades_cancelled = $cancellingBusinessStat->no_of_trades_cancelled + 1;
                        $cancellingBusinessStat->save();
                    }

                }
            }

            if ($exchangeTransaction->isDirty('owner_submitted_feedback') && $exchangeTransaction->owner_submitted_feedback == true)
            {
                $feedback = ExchangeFeedback::where(['exchange_trnx_id'=>$exchangeTransaction->id,'reviewed_business_code'=>$exchangeTransaction->trader_business_code])->first();
                $traderStat = ExchangeStat::where('business_code', $exchangeTransaction->trader_business_code)->first();
                if($feedback->review == 1){
                    $traderStat->no_of_positive_feedback = $traderStat->no_of_positive_feedback + 1;
                }
                if($feedback->review == 0){
                    $traderStat->no_of_negative_feedback = $traderStat->no_of_negative_feedback + 1;
                }
                $traderStat->save();
            }

            if ($exchangeTransaction->isDirty('trader_submitted_feedback') && $exchangeTransaction->trader_submitted_feedback == true)
            {
                $feedback = ExchangeFeedback::where(['exchange_trnx_id'=>$exchangeTransaction->id,'reviewed_business_code'=>$exchangeTransaction->owner_business_code])->first();
                $ownerStat = ExchangeStat::where('business_code', $exchangeTransaction->owner_business_code)->first();
                if($feedback->review == 1){
                    $ownerStat->no_of_positive_feedback = $ownerStat->no_of_positive_feedback + 1;
                }
                if($feedback->review == 0){
                    $ownerStat->no_of_negative_feedback = $ownerStat->no_of_negative_feedback + 1;
                }
                $ownerStat->save();
            }
        });
    }

    public function owner_business() : BelongsTo
    {
        return $this->belongsTo(Business::class,'owner_business_code','code');
    }

    public function trader_business() : BelongsTo
    {
        return $this->belongsTo(Business::class,'trader_business_code','code');
    }

    public function exchange_ad() : BelongsTo
    {
        return $this->belongsTo(ExchangeAds::class, 'exchange_ads_code', 'code');
    }

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class, 'trader_business_code', 'code');
    }

    public function paymentMethod() : HasOne
    {
        return $this->HasOne(ExchangePaymentMethod::class,'id','trader_action_via_method_id');
    }

    public function exchange_chats() : HasMany
    {
        return $this->hasMany(ExchangeChat::class,'exchange_trnx_id','id');
    }

    public function exchange_feedback() : HasMany
    {
        return $this->hasMany(ExchangeFeedback::class,'exchange_trnx_id','id');
    }

    public function isUserAllowed(User $user)
    {
        $isRelated = false;

        if($this->owner_business->code == $user->business_code){
            $isRelated = true;
        }
        if($this->trader_business->code == $user->business_code){
            $isRelated = true;
        }

        return $isRelated;
    }

    public function isTrader(User $user)
    {
        if($user->business_code == $this->trader_business_code){
            return true;
        }
        return false;
    }

    public function isOwner(User $user)
    {
        if($user->business_code == $this->owner_business_code){
            return true;
        }
        return false;
    }
}

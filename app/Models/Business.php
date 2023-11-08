<?php

namespace App\Models;

use App\Utils\Enums\BusinessStatusEnum;
use App\Utils\Enums\WalkThroughStepEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Business extends Model
{
    use HasFactory;

    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class,'country_code','code');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'code', 'code');
    }

    public function users(): BelongsTo //to cover all usage scope
    {
        return $this->belongsTo(User::class, 'code', 'code');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'code', 'code');
    }

    public function taskSubmissions(): HasManyThrough
    {
        return $this->hasManyThrough(VasSubmission::class, VasContract::class,'agent_code','vas_contract_code','code','code');
    }

    public function agentsSubmissions(): HasManyThrough
    {
        return $this->hasManyThrough(VasSubmission::class, VasContract::class,'vas_business_code','vas_contract_code','code','code');
    }

    public function vasPaymentsDone(): HasManyThrough
    {
        return $this->hasManyThrough(VasPayment::class, VasContract::class,'vas_business_code','vas_contract_code','code','code');
    }

    public function parent_referral()
    {
        return $this->belongsTo(Business::class, 'referral_business_code', 'code');
    }

    public function referrals()
    {
        return $this->hasMany(Business::class, 'referral_business_code', 'code');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class, 'business_code', 'code');
    }

    public function location_users()
    {
        return $this->hasMany(LocationUser::class, 'business_code', 'code');
    }

    public function locations()
    {
        return $this->hasMany(Location::class, 'business_code', 'code');
    }

    public function networks()
    {
        return $this->hasMany(Network::class, 'business_code', 'code');
    }

    public function shift_networks()
    {
        return $this->hasMany(ShiftNetwork::class, 'business_code', 'code');
    }

    public function shift_transactions()
    {
        return $this->hasMany(ShiftTransaction::class, 'business_code', 'code');
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class, 'business_code', 'code');
    }

    public function shorts()
    {
        return $this->hasMany(Short::class, 'business_code', 'code');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'business_code', 'code');
    }

    public function exchange_ads()
    {
        return $this->hasMany(ExchangeAds::class, 'business_code', 'code');
    }

    public function exchange_transactions_owned()
    {// for vas provider
        return $this->hasMany(ExchangeTransaction::class, 'owner_business_code', 'code');
    }

    public function exchange_transactions_requested()
    {//for agent
        return $this->hasMany(ExchangeTransaction::class, 'trader_business_code', 'code');
    }

    public function vas_contracts_owned()
    {//for vas provider
        return $this->hasMany(VasContract::class, 'vas_business_code', 'code');
    }

    public function vas_contracts()
    {//for agent
        return $this->hasMany(VasContract::class, 'agent_business_code', 'code');
    }

    public function vas_feedbacks_vas()
    {//for vas
        return $this->hasMany(VasFeedback::class, 'vas_business_code', 'code');
    }

    public function vas_feedbacks_agent()
    {//for agent
        return $this->hasMany(VasFeedback::class, 'agent_business_code', 'code');
    }

    public function vas_tasks()
    {
        return $this->hasMany(VasTask::class, 'vas_business_code', 'code');
    }

    public function vas_task_availabilities()
    {
        return $this->hasMany(VasTaskAvailability::class, 'agent_business_code', 'code');
    }

}

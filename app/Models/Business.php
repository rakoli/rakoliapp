<?php

namespace App\Models;

use App\Utils\Enums\BusinessStatusEnum;
use App\Utils\Enums\WalkThroughStepEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function parent_referral(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'referral_business_code', 'code');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Business::class, 'referral_business_code', 'code');
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class, 'business_code', 'code');
    }

    public function location_users(): HasMany
    {
        return $this->hasMany(LocationUser::class, 'business_code', 'code');
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class, 'business_code', 'code');
    }

    public function networks(): HasMany
    {
        return $this->hasMany(Network::class, 'business_code', 'code');
    }

    public function shift_networks(): HasMany
    {
        return $this->hasMany(ShiftNetwork::class, 'business_code', 'code');
    }

    public function shift_transactions(): HasMany
    {
        return $this->hasMany(ShiftTransaction::class, 'business_code', 'code');
    }

    public function shifts(): HasMany
    {
        return $this->hasMany(Shift::class, 'business_code', 'code');
    }

    public function shorts(): HasMany
    {
        return $this->hasMany(Short::class, 'business_code', 'code');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'business_code', 'code');
    }

    public function exchange_ads(): HasMany
    {
        return $this->hasMany(ExchangeAds::class, 'business_code', 'code');
    }

    public function exchange_transactions_owned(): HasMany
    {// for vas provider
        return $this->hasMany(ExchangeTransaction::class, 'owner_business_code', 'code');
    }

    public function exchange_transactions_requested(): HasMany
    {//for agent
        return $this->hasMany(ExchangeTransaction::class, 'trader_business_code', 'code');
    }

    public function vas_contracts_owned(): HasMany
    {//for vas provider
        return $this->hasMany(VasContract::class, 'vas_business_code', 'code');
    }

    public function vas_contracts(): HasMany
    {//for agent
        return $this->hasMany(VasContract::class, 'agent_business_code', 'code');
    }

    public function vas_feedbacks_vas(): HasMany
    {//for vas
        return $this->hasMany(VasFeedback::class, 'vas_business_code', 'code');
    }

    public function vas_feedbacks_agent(): HasMany
    {//for agent
        return $this->hasMany(VasFeedback::class, 'agent_business_code', 'code');
    }

    public function vas_tasks(): HasMany
    {
        return $this->hasMany(VasTask::class, 'vas_business_code', 'code');
    }

    public function vas_task_availabilities(): HasMany
    {
        return $this->hasMany(VasTaskAvailability::class, 'agent_business_code', 'code');
    }

}

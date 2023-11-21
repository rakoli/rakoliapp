<?php

namespace App\Models;

use App\Utils\Enums\BusinessStatusEnum;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_code',
        'code',
        'business_name',
        'tax_id',
        'business_regno',
        'business_reg_date',
        'business_phone_number',
        'business_email',
        'business_location',
    ];

    public static function addBusiness($data)
    {
        DB::beginTransaction();

        try {
            $businessInstance = self::create($data);
            $country = Country::where('code',$businessInstance->country_code)->first();
            $locationName = $businessInstance->business_name . " HQ";
            Location::create([
                'business_code' => $businessInstance->code,
                'code' => generateCode($locationName,$country->code) ,
                'name' => $locationName,
                'balance' => 0,
                'balance_currency' => $country->currency,
            ]);
            DB::commit();
        }catch (\Exception $exception) {
            DB::rollback();
            Log::debug("ADD BUSINESS ERROR: ".$exception->getMessage());
            Bugsnag::notifyException($exception);
            return false;
        }

        return $businessInstance;
    }

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


    public function verificationUploads(): HasMany
    {
        return $this->hasMany(BusinessVerificationUpload::class, 'business_code', 'code');
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

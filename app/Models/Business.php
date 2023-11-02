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
    protected $fillable=[
        'country_code',
        'code',
        'Business_name',
        'tax_id',
        'Business_regno',
        'Business_phone_number',
        'Business_email',
        "Business_Code",
        'Business_location',
        "Package_code"

    ];


    protected $casts  = [
        'walkthrough_step' => WalkThroughStepEnums::class,
        'status' => BusinessStatusEnum::class,
    ];

    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class,'country_code','code');
    }

    public function user(): BelongsTo
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
        return $this->hasManyThrough(VasSubmission::class, VasContract::class,'vas_provider_code','vas_contract_code','code','code');
    }
}

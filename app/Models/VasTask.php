<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VasTask extends Model
{
    use HasFactory;

    public function area() : BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_code', 'code');
    }

    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function region() : BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_code', 'code');
    }

    public function town() : BelongsTo
    {
        return $this->belongsTo(Towns::class, 'town_code', 'code');
    }

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class, 'vas_business_code', 'code');
    }

    public function vas_contracts() : HasMany
    {
        return $this->hasMany(VasContract::class, 'vas_task_code', 'code');
    }

    public function vas_feedbacks() : HasMany
    {
        return $this->hasMany(VasFeedback::class, 'vas_task_code', 'code');
    }

    public function vas_task_availabilities() : HasMany
    {
        return $this->hasMany(VasTaskAvailability::class, 'vas_task_code', 'code');
    }

    public function vas_task_instructions() : HasMany
    {
        return $this->hasMany(VasTaskInstruction::class, 'vas_task_code', 'code');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VasTask extends Model
{
    use HasFactory;

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_code', 'code');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_code', 'code');
    }

    public function town()
    {
        return $this->belongsTo(Towns::class, 'town_code', 'code');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'vas_business_code', 'code');
    }

    public function vas_contracts()
    {
        return $this->hasMany(VasContract::class, 'vas_task_code', 'code');
    }

    public function vas_feedbacks()
    {
        return $this->hasMany(VasFeedback::class, 'vas_task_code', 'code');
    }

    public function vas_task_availabilities()
    {
        return $this->hasMany(VasTaskAvailability::class, 'vas_task_code', 'code');
    }

    public function vas_task_instructions()
    {
        return $this->hasMany(VasTaskInstruction::class, 'vas_task_code', 'code');
    }

}

<?php

namespace App\Models;

use App\Models\Scopes\BusinessScoped;
use App\Models\Scopes\LocationScoped;
use App\Utils\Enums\LoanPaymentStatusEnum;
use App\Utils\Enums\LoanTypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    use HasFactory;

    protected $casts  = [
        'status' => LoanPaymentStatusEnum::class,
        'type'  => LoanTypeEnum::class,
    ];


    protected $guarded = [
        'id'
    ];
    protected static function booted()
    {
        static::addGlobalScope(new BusinessScoped);
        static::addGlobalScope(new LocationScoped);
    }

    public function business() : BelongsTo
    {
        return  $this->belongsTo(Business::class,'business_code','code');
    }

    public function user() : BelongsTo
    {
        return  $this->belongsTo(User::class,'user_code','code');
    }

    public function network() : BelongsTo
    {
        return  $this->belongsTo(Network::class,'network_code','code');
    }

    public function payments() : HasMany
    {
        return  $this->hasMany(LoanPayment::class,'loan_code','code');
    }

    public function shift() : BelongsTo
    {
        return  $this->belongsTo(Shift::class);
    }

    public function location() : BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_code', 'code');
    }

    public function balance() : Attribute
    {
        return  new Attribute(
            get: fn() : float => $this->amount - $this->payments()->sum('amount')
        );
    }
}

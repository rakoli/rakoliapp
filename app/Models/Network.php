<?php

namespace App\Models;

use App\Models\Scopes\BusinessScoped;
use App\Models\Scopes\LocationScoped;
use App\Utils\Enums\NetworkTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Network extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope(new LocationScoped());
        static::addGlobalScope(new BusinessScoped());
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_code', 'code');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_code', 'code');
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(FinancialServiceProvider::class, 'fsp_code', 'code');
    }

    public function crypto(): BelongsTo
    {
        return $this->belongsTo(Crypto::class, 'crypto_code', 'code');
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class, 'network_code', 'code');
    }

    public function shifts(): BelongsToMany
    {
        return $this->belongsToMany(Shift::class, 'shift_networks', 'network_code')
            ->withPivot('id', 'business_code', 'location_code', 'balance_old', 'balance_new')
            ->withTimestamps();
    }

    public function shift_transactions(): HasMany
    {
        return $this->hasMany(ShiftTransaction::class, 'network_code', 'code');
    }

    public function shorts(): HasMany
    {
        return $this->hasMany(Short::class, 'network_code', 'code');
    }

    public static function addBusinessDefaultTills(Business $business, Location $location)
    {
        $fsps = FinancialServiceProvider::where([
            'country_code' => $business->country_code,
            'is_default' => true
        ])->get();


        foreach ($fsps as $fsp){
            Network::create([
                'type' => NetworkTypeEnum::FINANCE,
                'code' => generateCode($fsp->name,$business->code),
                'business_code' => $business->code,
                'location_code' => $location->code,
                'fsp_code' => $fsp->code,
                'name' => $fsp->name .' Default',
                'agent_no' => 'Default '.random_int(1,99),
                'description' => 'System default till, edit details or remove',
                'balance' => 0,
                'balance_currency' => $business->country->currency,
            ]);
        }

    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logAll();
    }
}

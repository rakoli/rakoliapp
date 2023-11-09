<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, AuthenticationLoggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'country_code',
        'current_location_code',
        'phone',
        'phone_otp',
        'email_otp',
        'isVerified',
        'AuthToken',
        'iddoc_type',
        'iddoc_id',
        'iddoc_path',
        'is_super_agent',
        'status',
        'should_change_password',
        'code', // Add the 'code' attribute for user registration
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class,'business_code','code');
    }

    public function loan_payments()
    {
        return $this->hasMany(LoanPayment::class, 'user_code', 'code');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class, 'user_code', 'code');
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'location_users', 'user_code', 'location_code')
            ->withPivot('id', 'business_code')
            ->withTimestamps();
    }

    public function shift_transactions()
    {
        return $this->hasMany(ShiftTransaction::class, 'user_code', 'code');
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class, 'user_code', 'code');
    }

    public function short_payments()
    {
        return $this->hasMany(ShortPayment::class, 'user_code', 'code');
    }

    public function shorts()
    {
        return $this->hasMany(Short::class, 'user_code', 'code');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_code', 'code');
    }

    public function vas_submitter_submissions()
    {
        return $this->hasMany(VasSubmission::class, 'submitter_user_code', 'code');
    }

    public function vas_reviewer_submissions()
    {
        return $this->hasMany(VasSubmission::class, 'reviewer_user_code', 'code');
    }

    public function vas_chats()
    {
        return $this->hasMany(VasChat::class, 'sender_code', 'code');
    }

    public function ads_exchange_chats()
    {
        return $this->hasMany(AdsExchangeChat::class, 'sender_code', 'code');
    }

}

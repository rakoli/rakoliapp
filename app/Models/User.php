<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Actions\InitiateSubscriptionPayment;
use App\Utils\Enums\InitiatedPaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'type',
        'fname',
        'lname',
        'email',
        'password',
        'country_code',
        'phone',
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

    public function name()
    {
        return $this->fname .' '.$this->lname;
    }

    public function getEmailOTPCode()
    {
        return $this->email_otp;
    }

    public function getPhoneOTPCode()
    {
        return $this->phone_otp;
    }

    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class,'country_code','code');
    }

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class,'business_code','code');
    }

    public function loan_payments() : HasMany
    {
        return $this->hasMany(LoanPayment::class, 'user_code', 'code');
    }

    public function loans() : HasMany
    {
        return $this->hasMany(Loan::class, 'user_code', 'code');
    }

    public function locations() : BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'location_users', 'user_code', 'location_code')
            ->withPivot('id', 'business_code')
            ->withTimestamps();
    }

    public function shift_transactions() : HasMany
    {
        return $this->hasMany(ShiftTransaction::class, 'user_code', 'code');
    }

    public function shifts() : HasMany
    {
        return $this->hasMany(Shift::class, 'user_code', 'code');
    }

    public function short_payments() : HasMany
    {
        return $this->hasMany(ShortPayment::class, 'user_code', 'code');
    }

    public function shorts() : HasMany
    {
        return $this->hasMany(Short::class, 'user_code', 'code');
    }

    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class, 'user_code', 'code');
    }

    public function vas_submitter_submissions() : HasMany
    {
        return $this->hasMany(VasSubmission::class, 'submitter_user_code', 'code');
    }

    public function vas_reviewer_submissions() : HasMany
    {
        return $this->hasMany(VasSubmission::class, 'reviewer_user_code', 'code');
    }

    public function vas_chats() : HasMany
    {
        return $this->hasMany(VasChat::class, 'sender_code', 'code');
    }

    public function ads_exchange_chats() : HasMany
    {
        return $this->hasMany(ExchangeChat::class, 'sender_code', 'code');
    }

    public function getBusinessPendingPayments()
    {
        return InitiatedPayment::where('business_code',$this->business_code)
            ->where('expiry_time','>',now())
            ->where('status',InitiatedPaymentStatusEnum::INITIATED->value)->get();
    }

    public function hasPendingPayment() : bool
    {
        $initiatedPayments = $this->getBusinessPendingPayments();

        if($initiatedPayments->isEmpty()){
            return false;
        }

        return true;
    }

    public function lastSeenUpdate()
    {
        $busines = $this->business;
        $busines->last_seen = now();
        $busines->save();
    }

}

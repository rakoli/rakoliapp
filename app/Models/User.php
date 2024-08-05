<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Actions\InitiateSubscriptionPayment;
use App\Actions\SendTelegramNotification;
use App\Mail\WelcomeMail;
use App\Utils\Enums\InitiatedPaymentStatusEnum;
use App\Utils\Enums\UserTypeEnum;
use App\Utils\Traits\BusinessAuthorization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, AuthenticationLoggable, SoftDeletes,BusinessAuthorization;

    protected $fillable = [
        'type',
        'business_code',
        'fname',
        'lname',
        'email',
        'password',
        'country_code',
        'phone',
        'code', // Add the 'code' attribute for user registration
        'referral_business_code',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->fname} {$this->lname}";
    }

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

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Location::class,
            table: 'location_users',
            foreignPivotKey: "user_code",
            relatedPivotKey: "location_code",
            parentKey: "code",
            relatedKey: "code",
        )->using(class: LocationUser::class)
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

    public function getBusinessPendingPayments($limitArray = null)
    {
        $query = InitiatedPayment::where('business_code',$this->business_code)
            ->where('expiry_time','>',now())
            ->where('status',InitiatedPaymentStatusEnum::INITIATED->value);
        if($limitArray != null){
            return $query->get($limitArray);
        }
        return $query->get();
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
        if($busines != null){
            $busines->last_seen = now();
            $busines->save();
        }
    }

    // public function userRoles(): HasMany
    // {
    //     return $this->hasMany(UserRole::class, 'user_code', 'code');
    // }

    public function businessRoles(): HasManyThrough
    {
        return $this->hasManyThrough( BusinessRole::class,UserRole::class,'user_code','code','code','user_role');
    }

    public function canAccessMobileApp(): bool
    {
        if($this->type != UserTypeEnum::AGENT->value){
            return false;
        }
        return true;
    }

    public static function addUser($data)
    {
        $country_code = Country::where('dialing_code',$data['country_dial_code'])->first()->code;
        $country_dial_code = substr($data['country_dial_code'], 1);
        $plainPhone = substr($data['phone'], 1);
        $fullPhone = $country_dial_code . $plainPhone;
        $referralBusinessCode = null;
        if(array_key_exists('referral_business_code', $data)){
            $referralBusinessCode = $data['referral_business_code'];
        }
        return User::create([
            'country_code' => $country_code,
            'code' => generateCode($data['fname'].' '.$data['lname'],$country_code),
            'type' => UserTypeEnum::AGENT->value,
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'phone' => $fullPhone,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'referral_business_code' => $referralBusinessCode,
        ]);
    }

    public static function completedRegistration(User $user)
    {
        Mail::to($user->email)->send(new WelcomeMail($user));

        if(env('APP_ENV') == 'production'){
            $message = "User Registration: A new $user->type user $user->fname $user->lname from $user->country_code. (+$user->phone). Registration process ongoing.";
            SendTelegramNotification::dispatch($message);
        }

    }

}

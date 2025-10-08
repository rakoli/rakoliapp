<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Actions\InitiateSubscriptionPayment;
use App\Actions\SendTelegramNotification;
use App\Mail\WelcomeMail;
use App\Utils\Enums\InitiatedPaymentStatusEnum;
use App\Utils\Enums\UserTypeEnum;
use App\Utils\Traits\BusinessAuthorization;
use Carbon\Carbon;
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
        'pin',
        'country_code',
        'phone',
        'code', // Add the 'code' attribute for user registration
        'referral_business_code',
        'isowner',
        'registration_step',
        'phone_verified_at',
        'email_verified_at',
        'id_verified_at',
        'is_locked',
        'failed_login_attempts',
        'locked_until',
        'is_disabled',
        'pin_reset_otp',
        'pin_reset_otp_time',
        'pin_reset_otp_count',
        'pin_reset_token',
        'pin_reset_token_expires_at',
    ];

    protected $hidden = [
        'password',
        'pin',
        'pin_reset_otp',
        'pin_reset_token',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'locked_until' => 'datetime',
        'is_locked' => 'boolean',
        'is_disabled' => 'boolean',
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

    public function referralBusiness() : BelongsTo
    {
        return $this->belongsTo(Business::class,'referral_business_code','code');
    }

    public function referredUsers() : HasMany
    {
        return $this->hasMany(User::class, 'referral_business_code', 'business_code');
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
        if(array_key_exists('country_code', $data)){
            $country = Country::where('code',$data['country_code'])->first();
        } else {
            $country = Country::where('dialing_code',$data['country_dial_code'])->first();
        }
        $country_dial_code = substr($country->dialing_code,1);
        $plainPhone = null;
        if (str_starts_with($data['phone'], '0')) {
            $plainPhone = substr($data['phone'], 1);
        } else {
            $plainPhone = $data['phone'];
        }

        $fullPhone = $country_dial_code . $plainPhone;
        $referralBusinessCode = null;
        if(array_key_exists('referral_business_code', $data)){
            $referralBusinessCode = $data['referral_business_code'];
        }
        // Handle both web (password) and mobile (pin) registration
        $userData = [
            'country_code' => $country->code,
            'code' => generateCode($data['fname'].' '.$data['lname'],$country->code),
            'type' => isset($data['type']) ? $data['type'] : UserTypeEnum::AGENT->value,
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'phone' => $fullPhone,
            'email' => $data['email'],
            'referral_business_code' => $referralBusinessCode,
            'isowner' => isset($data['type']) ? 1 : 0,
            'registration_step' => isset($data['type']) ? 0 : 3,
            'phone_verified_at' => isset($data['type'])  ? Carbon::now() : NULL,
            'email_verified_at' => isset($data['type']) ? Carbon::now() : NULL,
            'id_verified_at' => isset($data['type']) ? Carbon::now() : NULL,
        ];

        // For mobile API: use PIN and set dummy password
        if (isset($data['pin'])) {
            $userData['pin'] = Hash::make($data['pin']);
            $userData['password'] = Hash::make('dummy_password_' . time()); // Dummy password for mobile users
        }
        // For web: use password
        elseif (isset($data['password'])) {
            $userData['password'] = Hash::make($data['password']);
        }

        return User::create($userData);
    }

    public static function completedRegistration(User $user)
    {

        if(env('APP_ENV') == 'production'){
            $message = "User Registration: A new $user->type user $user->fname $user->lname from $user->country_code. (+$user->phone). Registration process ongoing.";
            SendTelegramNotification::dispatch($message);
        }

    }

    /**
     * Check if user account is locked due to failed login attempts
     */
    public function isAccountLocked(): bool
    {
        if ($this->is_disabled) {
            return true;
        }

        if ($this->is_locked && $this->locked_until && now()->lt($this->locked_until)) {
            return true;
        }

        // If lock period has expired, unlock the account
        if ($this->is_locked && $this->locked_until && now()->gte($this->locked_until)) {
            $this->unlockAccount();
        }

        return false;
    }

    /**
     * Increment failed login attempts and lock account if necessary
     */
    public function incrementFailedAttempts(): void
    {
        $this->failed_login_attempts++;

        if ($this->failed_login_attempts >= 4) {
            if ($this->failed_login_attempts == 4) {
                // First time reaching 4 attempts - lock for 30 minutes
                $this->is_locked = true;
                $this->locked_until = now()->addMinutes(30);
            } else {
                // More than 4 attempts - disable account permanently
                $this->is_disabled = true;
                $this->is_locked = true;
                $this->locked_until = null;
            }
        }

        $this->save();
    }

    /**
     * Reset failed login attempts on successful login
     */
    public function resetFailedAttempts(): void
    {
        $this->failed_login_attempts = 0;
        $this->save();
    }

    /**
     * Unlock account (called when lock period expires)
     */
    public function unlockAccount(): void
    {
        $this->is_locked = false;
        $this->locked_until = null;
        $this->save();
    }

    /**
     * Verify PIN
     */
    public function verifyPin(string $pin): bool
    {
        return Hash::check($pin, $this->pin);
    }

    /**
     * Set PIN (hash it for security)
     */
    public function setPin(string $pin): void
    {
        $this->pin = Hash::make($pin);
        $this->save();
    }

    /**
     * Check if user has active PIN reset OTP
     */
    public function hasActivePinResetOTP(): bool
    {
        if (!$this->pin_reset_otp || !$this->pin_reset_otp_time) {
            return false;
        }

        $validTime = config('app.otp_valid_time', 300); // 5 minutes default
        $otpAge = now()->diffInSeconds($this->pin_reset_otp_time);

        return $otpAge < $validTime;
    }

    /**
     * Check if PIN reset should be locked (too many attempts)
     */
    public function shouldLockPinReset(): bool
    {
        $maxAttempts = config('app.otp_max_attempts', 5);
        return $this->pin_reset_otp_count >= $maxAttempts;
    }

    /**
     * Verify PIN reset OTP
     */
    public function verifyPinResetOTP(string $otp): bool
    {
        if (!$this->hasActivePinResetOTP()) {
            return false;
        }

        return $this->pin_reset_otp === $otp;
    }

    /**
     * Reset PIN reset OTP data
     */
    public function clearPinResetOTP(): void
    {
        $this->pin_reset_otp = null;
        $this->pin_reset_otp_time = null;
        $this->pin_reset_otp_count = 0;
        $this->save();
    }

    /**
     * Find user by phone number
     */
    public static function findByPhone(string $phone): ?User
    {
        return static::where('phone', $phone)->first();
    }

}

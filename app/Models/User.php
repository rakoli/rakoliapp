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
        'country_code',
        'phone',
        'code', // Add the 'code' attribute for user registration
        'referral_business_code',
        'isowner',
        'registration_step',
        'phone_verified_at',
        'email_verified_at',
        'id_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at',
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

    public function referralBusiness() : BelongsTo
    {
        return $this->belongsTo(Business::class,'referral_business_code','code');
    }

    public function referredUsers() : HasMany
    {
        return $this->hasMany(User::class, 'referral_business_code', 'business_code');
    }

    public function referralPayments() : HasMany
    {
        return $this->hasMany(ReferralPayment::class);
    }

    public function referralPaymentsReceived() : HasMany
    {
        return $this->hasMany(ReferralPayment::class, 'referral_id');
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
        return User::create([
            'country_code' => $country->code,
            'code' => generateCode($data['fname'].' '.$data['lname'],$country->code),
            'type' => isset($data['type']) ? $data['type'] : UserTypeEnum::AGENT->value,
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'phone' => $fullPhone,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'referral_business_code' => $referralBusinessCode,
            'isowner' => isset($data['type']) ? 1 : 0,
            'registration_step' => isset($data['type']) ? 0 : 3,
            'phone_verified_at' => isset($data['type'])  ? Carbon::now() : NULL,
            'email_verified_at' => isset($data['type']) ? Carbon::now() : NULL,
            'id_verified_at' => isset($data['type']) ? Carbon::now() : NULL,
        ]);
    }

    public static function completedRegistration(User $user)
    {

        if(env('APP_ENV') == 'production'){
            $message = "User Registration: A new $user->type user $user->fname $user->lname from $user->country_code. (+$user->phone). Registration process ongoing.";
            SendTelegramNotification::dispatch($message);
        }

    }

    /**
     * Get the first week transaction count for a referred business
     */
    public function getFirstWeekTransactionsCount()
    {
        if (!$this->business) {
            return 0;
        }

        $referralDate = $this->created_at;
        $weekAfter = $referralDate->copy()->addWeek();

        return Transaction::where('business_code', $this->business->code)
            ->whereBetween('created_at', [$referralDate, $weekAfter])
            ->count();
    }

    /**
     * Get the second week transaction count for a referred business
     */
    public function getSecondWeekTransactionsCount()
    {
        if (!$this->business) {
            return 0;
        }

        $referralDate = $this->created_at;
        $weekAfter = $referralDate->copy()->addWeek();
        $twoWeeksAfter = $referralDate->copy()->addWeeks(2);

        return Transaction::where('business_code', $this->business->code)
            ->whereBetween('created_at', [$weekAfter, $twoWeeksAfter])
            ->count();
    }

    /**
     * Check if registration is completed (has business with package)
     */
    public function isRegistrationCompleted()
    {
        return $this->business && $this->business->package_code;
    }

    /**
     * Get total referral earnings for this referred user
     */
    public function getTotalReferralEarnings()
    {
        $earnings = 0;

        // Registration bonus
        if ($this->isRegistrationCompleted()) {
            $earnings += 500;
        }

        // Week 1 transaction bonus
        if ($this->getFirstWeekTransactionsCount() >= 10) {
            $earnings += 1000;
        }

        // Week 2 transaction bonus
        if ($this->getSecondWeekTransactionsCount() >= 10) {
            $earnings += 1000;
        }

        return $earnings;
    }

    /**
     * Get bonus eligibility status
     */
    public function getBonusStatus()
    {
        $now = now();
        $referralDate = $this->created_at;
        $twoWeeksAfter = $referralDate->copy()->addWeeks(2);

        if ($now > $twoWeeksAfter) {
            return [
                'status' => 'expired',
                'label' => 'Expired',
                'class' => 'badge-danger'
            ];
        } else {
            $daysLeft = $now->diffInDays($twoWeeksAfter);
            return [
                'status' => 'active',
                'label' => $daysLeft . ' days left',
                'class' => 'badge-info'
            ];
        }
    }

    /**
     * Payment tracking methods
     */
    public function getTotalEarnings()
    {
        return $this->referralPayments()->sum('amount');
    }

    public function getTotalPaid()
    {
        return $this->referralPayments()->where('payment_status', 'paid')->sum('amount');
    }

    public function getRemainingBalance()
    {
        return $this->getTotalEarnings() - $this->getTotalPaid();
    }

    public function getPendingPayments()
    {
        return $this->referralPayments()->where('payment_status', 'pending')->sum('amount');
    }

    public function getPaymentStatusAttribute()
    {
        $pending = $this->getPendingPayments();
        $total = $this->getTotalEarnings();

        if ($total == 0) {
            return ['status' => 'none', 'label' => 'No Earnings', 'class' => 'badge-secondary'];
        } elseif ($pending == 0) {
            return ['status' => 'paid', 'label' => 'Fully Paid', 'class' => 'badge-success'];
        } elseif ($pending == $total) {
            return ['status' => 'pending', 'label' => 'Pending Payment', 'class' => 'badge-warning'];
        } else {
            return ['status' => 'partial', 'label' => 'Partially Paid', 'class' => 'badge-info'];
        }
    }

    public function getLastPaymentDate()
    {
        $lastPayment = $this->referralPayments()->where('payment_status', 'paid')->latest('paid_at')->first();
        return $lastPayment ? $lastPayment->paid_at : null;
    }

    /**
     * Create payment records when bonuses are earned
     */
    public function createRegistrationBonusPayment($referralId)
    {
        // Check if payment record already exists
        $exists = $this->referralPayments()
            ->where('referral_id', $referralId)
            ->where('payment_type', 'registration_bonus')
            ->exists();

        if (!$exists) {
            return ReferralPayment::createRegistrationBonus($this->id, $referralId);
        }

        return null;
    }

    public function createTransactionBonusPayment($referralId, $week)
    {
        $type = $week === 1 ? 'transaction_bonus_week1' : 'transaction_bonus_week2';

        // Check if payment record already exists
        $exists = $this->referralPayments()
            ->where('referral_id', $referralId)
            ->where('payment_type', $type)
            ->exists();

        if (!$exists) {
            return ReferralPayment::createTransactionBonus($this->id, $referralId, $week);
        }

        return null;
    }

}

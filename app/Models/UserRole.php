<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRole extends Model
{
    use HasFactory;
    protected $fillable = [
        'business_code',
        'user_code',
        'user_role',
    ];

    protected $table = 'user_roles';

    public function user(): BelongsTo
    {
        return  $this->belongsTo(User::class,'user_code','code');
    }

    public function location(): BelongsTo
    {
        return  $this->belongsTo(BusinessRole::class,'user_role','code');
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_code', 'code');
    }


}

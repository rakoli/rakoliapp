<?php

namespace App\Models;

use App\Models\Scopes\BusinessScoped;
use App\Models\Scopes\LocationScoped;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Database\Factories\SystemIncomeFactory;
use Database\Factories\TransactionsFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $casts = [
        'type'  => TransactionTypeEnum::class,
        'category' => TransactionCategoryEnum::class,
    ];

    protected static function newFactory(): Factory
    {
        return TransactionsFactory::new();
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_code', 'code');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_code', 'code');
    }

    public function business() :BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_code', 'code');
    }

}

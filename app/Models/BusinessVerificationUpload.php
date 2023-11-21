<?php

namespace App\Models;

use App\Utils\Enums\BusinessUploadDocumentTypeEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessVerificationUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_code',
        'document_type',
        'document_name',
        'document_path',
    ];


    protected $casts = [
        'document_type' => BusinessUploadDocumentTypeEnums::class
    ];

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class,'business_code','code');
    }
}

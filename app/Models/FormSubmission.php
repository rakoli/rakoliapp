<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_rep_name',
        'agent_name',
        'phone_number',
        'location',
        'gps_coordinates',
        'location_captured',
        'business_name',
        'mno_used',
        'other_mno',
        'vodacom_till',
        'airtel_till',
        'tigo_till',
        'bank_wallet',
        'visit_outcome',
        'decline_reason',
        'key_concerns',
        'suggestions',
        'agent_signature',
    ];

    protected $casts = [
        'mno_used' => 'array',
        'location_captured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}

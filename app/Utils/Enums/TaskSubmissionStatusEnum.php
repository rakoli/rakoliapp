<?php

namespace App\Utils\Enums;

enum TaskSubmissionStatusEnum: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}

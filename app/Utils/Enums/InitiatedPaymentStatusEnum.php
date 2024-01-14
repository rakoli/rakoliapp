<?php

namespace App\Utils\Enums;

enum InitiatedPaymentStatusEnum: string
{
    case INITIATED = 'initiated';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case EXPIRED = 'expired';
}

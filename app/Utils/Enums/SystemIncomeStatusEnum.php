<?php

namespace App\Utils\Enums;

enum SystemIncomeStatusEnum : string
{
    case RECEIVED = 'received';
    case DELETED = 'deleted';
    case PENDING_VERIFICATION = 'pending';
}

<?php

namespace App\Utils\Enums;

enum BusinessWithdrawMethodStatusEnum: string
{
    case REQUESTED = 'requested';
    case APPROVED = 'approved';
    case COMPLETE = 'complete';
}

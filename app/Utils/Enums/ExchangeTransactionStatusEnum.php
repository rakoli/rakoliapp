<?php

namespace App\Utils\Enums;

enum ExchangeTransactionStatusEnum : string
{
    case OPEN = "open";
    case CLOSED = "closed";
    case PENDING_RELEASE = "pending_release";
    case APPEAL = "appeal";
}

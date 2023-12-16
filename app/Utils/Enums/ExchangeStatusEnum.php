<?php

namespace App\Utils\Enums;

enum ExchangeStatusEnum : string
{
    case ACTIVE = "active";
    case PENDING = "pending";
    case DISABLED = "disabled";
    case DELETED = "deleted";
}

<?php

namespace App\Utils\Enums;

enum TransactionTypeEnum : string
{
    case MONEY_IN = "IN";
    case MONEY_OUT = "OUT";
}

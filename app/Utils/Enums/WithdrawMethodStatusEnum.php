<?php

namespace App\Utils\Enums;

enum WithdrawMethodStatusEnum : string
{
    case REQUESTED = "requested";
    case PROCESSING = "processing";
    case COMPLETED = "completed";
}
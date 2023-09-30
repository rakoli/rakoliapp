<?php

namespace App\Utils\Enums;

enum AdsStatusEnum : string
{

    case NEW = "new";

    case TRADE_COMPLETED = "trace completed";
    case TRADE_CANCELLED = "trade cancelled";
}

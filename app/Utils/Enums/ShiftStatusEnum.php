<?php

namespace App\Utils\Enums;

enum ShiftStatusEnum : string
{
    case OPEN = "open";
    case CLOSED = "closed";
    case INREVIEW = "inreview";
}

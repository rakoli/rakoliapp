<?php

namespace App\Utils\Enums;


enum UserStatusEnum : int
{
    case ACTIVE = 1;
    case BLOCKED = 0;
    case DISABLED = 2;
}

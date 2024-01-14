<?php

namespace App\Utils\Enums;

enum UserStatusEnum: int
{
    case active = 1;
    case inactive = 0;
    case disabled = 2;
}

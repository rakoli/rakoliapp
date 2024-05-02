<?php

namespace App\Utils\Enums;

enum NetworkTypeEnum: string
{
    case FINANCE = 'Finance';

    case CRYPTO = 'Crypto';

    public function label(): string
    {
        return match ($this) {
            self::FINANCE => 'Finance',
            self::CRYPTO => 'Crypto',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::CRYPTO => 'badge badge-success',
            self::FINANCE => 'badge badge-primary',
        };
    }
}

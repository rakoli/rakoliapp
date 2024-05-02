<?php

namespace App\Utils\Enums;

enum ShiftStatusEnum: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case INREVIEW = 'inreview';

    public function label(): string
    {
        return match ($this) {
            self::OPEN => 'Open',
            self::CLOSED => 'Closed',
            self::INREVIEW => 'In Review',
        };

    }

    public function color(): string
    {
        return match ($this) {
            self::OPEN => 'badge badge-primary',
            self::CLOSED => 'badge badge-danger',
            self::INREVIEW => 'badge badge-warning',
        };

    }
}

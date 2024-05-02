<?php

namespace App\Utils\Enums;

enum ShiftTransferRequestStatusEnum: string
{

    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejeted';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::ACCEPTED => 'Accepted',
            self::REJECTED => 'Rejeted',
        };

    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'badge badge-primary',
            self::ACCEPTED => 'badge badge-success',
            self::REJECTED => 'badge badge-danger',
        };

    }
}

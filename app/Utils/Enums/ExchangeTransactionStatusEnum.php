<?php

namespace App\Utils\Enums;

enum ExchangeTransactionStatusEnum: string
{
    case OPEN = 'open';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';
    case PENDING_RELEASE = 'pending_release';
    case APPEAL = 'appeal';

    public function description(): string
    {
        return match ($this) {
            ExchangeTransactionStatusEnum::OPEN => 'Waiting for Trade Payment',
            ExchangeTransactionStatusEnum::CANCELLED => 'Trade Cancelled',
            ExchangeTransactionStatusEnum::COMPLETED => 'Trade Complete',
            ExchangeTransactionStatusEnum::PENDING_RELEASE => 'Pending Payment Confirmation',
            ExchangeTransactionStatusEnum::APPEAL => 'Trade Appealed',
        };
    }
}

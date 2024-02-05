<?php

namespace App\Actions\Agent\Shift;

use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Utils\Enums\ShiftStatusEnum;

trait InteractsWithShift
{
    /**
     * @param array{network_code: string, amount: float, type: string , category: string , notes: ?string , description: ?string } $data
     *
     * @throws \Exception
     */
    public function createShiftTransaction(Shift $shift, array $data, float $oldBalance, $newBalance): void
    {

        $shift->transactions()->create([
            'business_code' => $shift->business_code,
            'location_code' => $shift->location_code,
            'network_code' => $data['network_code'],
            'code' => generateCode($shift->user_code, time()),
            'user_code' => auth()->user()->code,
            'amount' => $data['amount'],
            'amount_currency' => currencyCode(),
            'type' => $data['type'],
            'category' => $data['category'],
            'balance_old' => $oldBalance,
            'balance_new' => $newBalance,
            'description' => $data['description'] ?? null,
            'note' => $data['notes'] ?? null,
        ]);


    }


    public static function moneyIn(array $data, bool $isLoan = false): array
    {

        return [
            0, 0, 0
        ];
    }

    public static function moneyOut(array $data, bool $isLoan = false): array
    {

        return [
            0, 0, 0
        ];

    }


}

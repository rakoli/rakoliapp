<?php

namespace App\Actions\Agent\Shift;

use App\Models\Location;
use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Models\ShiftTransaction;
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


    // DEPOSIT Transaction
    public static function moneyIn(Shift $shift , array $data, bool $isLoan = false): array
    {

        // increase location balance

        $location = Location::query()
            ->where('code', $shift->location_code)
            ->first();


        $location->balance = $location->balance + $data['amount'];

        $location->saveQuietly();



        // get old shift network balance if no transaction then


        $lastTransaction = ShiftTransaction::query()
            ->whereBelongsTo($shift, 'shift')
            ->where([
                'location_code' => $shift->location_code,
                'network_code' => $data['network_code'],
            ])
            ->latest('created_at')
            ->first();

        if (! $lastTransaction)
        {

            $shiftNetwork =  ShiftNetwork::query()
                ->whereBelongsTo($shift, 'shift')
                ->where([
                    'location_code' => $shift->location_code,
                    'network_code' => $data['network_code'],
                ])
                ->first();

            return [
                $shiftNetwork->balance_old - $data['amount'],
                $shiftNetwork->balance_old,
            ];
        }

        return [
            $lastTransaction->balance_old - $data['amount'],
            $lastTransaction->balance_old,

        ];
    }

    public static function moneyOut(Shift $shift , array $data, bool $isLoan = false): array
    {

        // increase location balance

        $location = Location::query()
            ->where('code', $shift->location_code)
            ->first();


        $location->balance = $location->balance + $data['amount'];

        $location->saveQuietly();



        // get old shift network balance if no transaction then


        $lastTransaction = ShiftTransaction::query()
            ->whereBelongsTo($shift, 'shift')
            ->where([
                'location_code' => $shift->location_code,
                'network_code' => $data['network_code'],
            ])
            ->latest('created_at')
            ->first();

        if (! $lastTransaction)
        {

            $shiftNetwork =  ShiftNetwork::query()
                ->whereBelongsTo($shift, 'shift')
                ->where([
                    'location_code' => $shift->location_code,
                    'network_code' => $data['network_code'],
                ])
                ->first();

            return [
                $shiftNetwork->balance_old +  $data['amount'],
                $shiftNetwork->balance_old,
            ];
        }

        return [
            $lastTransaction->balance_old + $data['amount'],
            $lastTransaction->balance_old,

        ];
    }


}

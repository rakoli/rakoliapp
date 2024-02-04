<?php

namespace App\Actions\Agent\Shift;

use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Utils\Enums\ShiftStatusEnum;

trait InteractsWithShift
{
    /**
     * @param  array{network_code: string, amount: float, type: string , category: string , notes: ?string , description: ?string }  $data
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

        $this->updateNetworkBalance(
            shift: $shift,
            networkCode: $data['network_code'],
            olBalance: $oldBalance,
            newBalance: $newBalance,
        );
    }

    public static function moneyIn(array $data, bool $isLoan = false): array
    {



        // till for the opened shift

        $tillCheck = ShiftNetwork::query()
            ->whereHas('shift', fn ($query) => $query->where('status', ShiftStatusEnum::OPEN))
            ->where('network_code', $data['network_code']);

        if (! $tillCheck->exists()) {
            throw new \Exception('You cannot transact without an open shift');
        }

        /** @var ShiftNetwork $till */
        $till = $tillCheck
            ->with('shift')
            ->first();

        // increase cash

        $cash = $till->shift->cash_end;

        $shift = $till->shift;

        if (! $isLoan)
        {
            /** @var Shift $shift */

            $shift->updateQuietly([
                'cash_start' => $cash,
                'cash_end' => $cash + floatval($data['amount']),
            ]);
        }

        $newBalance = $till->balance_new;

        //dd($till->balance_new - floatval($data['amount']) ,   $cash + floatval($data['amount']));

        $till->updateQuietly([
            'balance_new' => $newBalance - floatval($data['amount']),
            'balance_old' => $newBalance,
        ]);

        $shift->refresh();

        return [
            $shift->cash_end,
            $shift->cash_start,
            $till,
        ];

    }

    public static function moneyOut(array $data, bool $isLoan = false): array
    {



        // till for the opened shift

        $tillCheck = ShiftNetwork::query()
            ->whereHas('shift', fn ($query) => $query->where('status', ShiftStatusEnum::OPEN))
            ->where('network_code', $data['network_code']);

        if (! $tillCheck->exists()) {
            throw new \Exception('You cannot transact without an open shift');
        }

        /** @var ShiftNetwork $till */
        $till = $tillCheck
            ->with('shift')
            ->first();

        // increase cash

        $newBalance = $till->balance_new;

        /** @var Shift $shift */
        $shift = $till->shift;



        if (! $isLoan)
        {
            $cash = $till->shift->cash_end;

            $cashEnd = $cash - floatval($data['amount']);

            $shift->updateQuietly([
                'cash_start' => floatval($cash),
                'cash_end' => floatval($cashEnd),
            ]);
        }



        $till->updateQuietly([
            'balance_old' => $newBalance,
            'balance_new' => $newBalance + floatval($data['amount']),
        ]);

        $shift->refresh();

        return [
            $shift->cash_end,
            $shift->cash_start,
            $till,
        ];

    }

    private function updateNetworkBalance(Shift $shift, string $networkCode, float $olBalance, float $newBalance): void
    {

        ShiftNetwork::query()
            ->whereBelongsTo($shift, 'shift')
            ->where('network_code', $networkCode)
            ->first()
            ->update([
                'balance_old' => $olBalance,
                'balance_new' => $newBalance,
            ]);

    }
}

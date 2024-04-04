<?php

namespace App\Actions\Agent\Shift;

use App\Events\Shift\LocationBalanceUpdate;
use App\Models\Location;
use App\Models\Shift;
use App\Models\ShiftCashTransaction;
use App\Models\ShiftNetwork;
use App\Models\ShiftTransaction;
use App\Models\Transaction;
use App\Utils\Enums\FundSourceEnums;
use Lorisleiva\Actions\Concerns\AsAction;

class AddIncomeTransaction
{
    use AsAction;
    use InteractsWithShift;

    /**
     * @param  array{ amount: float, type: string , category: string , income_type: string , notes: ?string,description: ?string }  $data
     *
     * @throws \Throwable
     */
    public function handle(Shift $shift, array $data): mixed
    {
        return runDatabaseTransaction(function () use ($shift, $data) {

            $source = FundSourceEnums::tryFrom($data['income_type']);

            $data['location_code'] = $shift->location_code;

            $data['business_code'] = $shift->business_code;

            if ($source === FundSourceEnums::TILL) {
                $this->tillTransaction(shift: $shift, data: $data);
            } else {
                $data['network_code'] = NULL;
                $this->cashTransaction(shift: $shift, data: $data);
            }
        });

    }

    private function tillTransaction(Shift $shift, array $data)
    {
        try {
            $location = Location::query()->where('code', $shift->location_code)->first();

            $balance = $location->balance;

            $data['location_new_balance'] = $balance;

            //record a location balance for this expense transaction

            $this->createLocationTransaction(
                data: $data,
                location: $location
            );

            $lastTransaction = ShiftTransaction::query()
                ->whereBelongsTo($shift, 'shift')
                ->where([
                    'location_code' => $shift->location_code,
                    'network_code' => $data['network_code'],
                ])
                ->latest('created_at')
                ->first();

            if (! $lastTransaction) {

                $shiftNetwork = ShiftNetwork::query()
                    ->whereBelongsTo($shift, 'shift')
                    ->where([
                        'location_code' => $shift->location_code,
                        'network_code' => $data['network_code'],
                    ])
                    ->first();

                $newBalance = $shiftNetwork->balance_new + $data['amount'];
                $oldBalance = floatval($shiftNetwork->balance_new);

            } else {
                $newBalance = $lastTransaction->balance_new + $data['amount'];

                $oldBalance = floatval($lastTransaction->balance_new);  // old balance
            }

            return $this->createShiftTransaction(
                shift: $shift,
                data: $data,
                oldBalance: $oldBalance,
                newBalance: $newBalance,
            );
        } catch (\Exception $exception) {
            throw new \Exception($exception);
        }
    }

    private function cashTransaction(Shift $shift, array $data)
    {
        try {
            $location = Location::query()->where('code', $shift->location_code)->first();

            $balance = $location->balance;

            $data['location_new_balance'] = $balance;

            //record a location balance for this expense transaction

            $this->createLocationTransaction(
                data: $data,
                location: $location
            );

            $lastTransaction = ShiftCashTransaction::query()
                ->whereBelongsTo($shift, 'shift')
                ->where([
                    'location_code' => $shift->location_code,
                ])
                ->latest('created_at')
                ->first();

            if (! $lastTransaction) {
                $newBalance = $balance + $data['amount'];
                $oldBalance = floatval($balance);

            } else {
                $newBalance = $lastTransaction->balance_new + $data['amount'];

                $oldBalance = floatval($lastTransaction->balance_new);  // old balance
            }

            return $this->createShiftCashTransaction(
                shift: $shift,
                data: $data,
                oldBalance: $oldBalance,
                newBalance: $newBalance,
            );
        } catch (\Exception $exception) {
            throw new \Exception($exception);
        }

        // $location = Location::query()->where('code', $shift->location_code)->first();

        // $balance = $location->balance;

        // $data['location_new_balance'] = $balance + floatval($data['amount']);

        // $this->createLocationTransaction(
        //     data: $data,
        //     location: $location,
        // );

        // $location->updateQuietly([
        //     'balance' => $balance + $data['amount'],
        // ]);

        // event(new LocationBalanceUpdate(location: $location, amount: $data['amount']));
    }
}

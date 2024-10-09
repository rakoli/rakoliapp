<?php

namespace App\Actions\Agent\Shift;

use App\Models\Shift;
use App\Models\ShiftCashTransaction;
use App\Models\ShiftNetwork;
use App\Models\ShiftTransaction;
use App\Utils\Enums\FundSourceEnums;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class AddIncomeTransaction
{
    use AsAction;
    use InteractsWithShift;

    /**
     * @param  array{ amount: float, type: string , category: string , source: string , notes: ?string,description: ?string }  $data
     *
     * @throws \Throwable
     */
    public function handle(Shift $shift, array $data): mixed
    {
        Log::info("AddIncomeTransaction :: Request Data".print_r($data,true));

        return runDatabaseTransaction(function () use ($shift, $data) {

            $source = FundSourceEnums::tryFrom($data['source']);

            $data['location_code'] = $shift->location_code;

            $data['business_code'] = $shift->business_code;

            if ($source === FundSourceEnums::TILL) {
                Log::info("AddIncomeTransaction :: Till Transaction"); 
                $status = $this->tillTransaction(shift: $shift, data: $data);
                if($status){
                    Log::info("AddIncomeTransaction :: Update Location Network Balance");
                    $this->updateBalance(shift: $shift, data: $data);
                }
            } else {
                Log::info("AddIncomeTransaction :: Cash Transaction");
                $data['network_code'] = NULL;
                $status = $this->cashTransaction(shift: $shift, data: $data);
                if($status){
                    Log::info("AddIncomeTransaction :: Update Location Balance");
                    $this->updateBalance(shift: $shift, data: $data);
                }
            }
        });

    }

    private function tillTransaction(Shift $shift, array $data)
    {
        try {

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
            Log::info($data);
            return $this->createShiftTransaction(
                shift: $shift,
                data: $data,
                oldBalance: $oldBalance,
                newBalance: $newBalance,
            );
        } catch (\Exception $exception) {
            Log::info("AddIncomeTransaction :: tillTransaction :: Exception :: ".print_r($exception->getMessage(),true));
            throw new \Exception($exception);
        }
    }

    private function cashTransaction(Shift $shift, array $data)
    {
        try {

            $lastTransaction = ShiftCashTransaction::query()
                ->whereBelongsTo($shift, 'shift')
                ->where([
                    'location_code' => $shift->location_code,
                ])
                ->latest('created_at')
                ->first();

            if (! $lastTransaction) {
                $last_balance = 0;
                $newBalance = $last_balance + $data['amount'];
                $oldBalance = floatval($last_balance);

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
            Log::info("AddIncomeTransaction :: cashTransaction :: Exception :: ".print_r($exception->getMessage(),true));
            throw new \Exception($exception);
        }
    }
}

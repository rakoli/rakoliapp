<?php

namespace App\Actions\Agent\Shift;

use App\Models\Location;
use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Models\Transaction;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class AddIncomeExpenseTransaction extends AddTransaction
{
    use  AsAction;

    /**
     * @throws \Throwable
     */
    public function handle(array $data)
    {

        try {

            DB::beginTransaction();


            [$newBalance, $oldBalance ] =  match ($data['type']){
                TransactionTypeEnum::MONEY_IN->value => static::moneyIn($data),
                TransactionTypeEnum::MONEY_OUT->value => static::moneyOut($data),
            };


            Transaction::create([
                'business_code' => auth()->user()->business_code,
                'location_code' => $data['location_code'],
                'user_code' => auth()->user()->code,
                'amount' => $data['amount'],
                'amount_currency' => currencyCode(),
                'type' => $data['type'],
                'category' => $data['category'],
                'balance_old' => $oldBalance,
                'balance_new' => $newBalance,
                'description' => $data['notes'],
            ]);

            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());


        }

    }


    // reduce till float and increase cash at hand
    private static function moneyIn(array $data): array
    {
        $location = Location::query()->where('code', $data['location_code'])->first();

        $oldBalance = $location->balance;

        $newBalance = $oldBalance + floatval( $data['amount']);

        $location->updateQuietly([
            'balance' => $newBalance,
            'currency' => currencyCode(),
        ]);


        return  [
            $newBalance,
            $oldBalance
        ];

    }

    // reduce cash and increase till float
    private static function moneyOut(array $data): array
    {
        $location = Location::query()->where('code', $data['location_code'])->first();

        $oldBalance = $location->balance;

        $newBalance = $oldBalance - floatval( $data['amount']);

        $location->updateQuietly([
            'balance' => $newBalance,
            'currency' => currencyCode(),
        ]);


        return  [
            $newBalance,
            $oldBalance
        ];

    }




}

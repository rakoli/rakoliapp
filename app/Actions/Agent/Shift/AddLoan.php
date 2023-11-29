<?php

namespace App\Actions\Agent\Shift;

use App\Models\Loan;
use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Models\Transaction;
use App\Utils\Enums\LoanPaymentStatusEnum;
use App\Utils\Enums\LoanTypeEnum;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class AddLoan
{
    use  AsAction;

    /**
     * @throws \Throwable
     */
    public function handle(array $data)
    {

        try {


           throw_if(condition:  ! Shift::query()->where('status', ShiftStatusEnum::OPEN)->exists(),
                exception: new \Exception("You cannot transact without an open shift")
            );


            DB::beginTransaction();

            $data['till_code'] = $data['location_code'];

            /*[$newBalance, $oldBalance ] =  match ($data['type']){
                TransactionTypeEnum::MONEY_IN->value => static::moneyIn($data),
                TransactionTypeEnum::MONEY_OUT->value => static::moneyOut($data),
            };*/

           $shiftId = Shift::query()->where('status', ShiftStatusEnum::OPEN)->pluck('id')->first();


            Loan::create([
                'business_code' => auth()->user()->business_code,
                'location_code' => $data['location_code'],
                'user_code' => auth()->user()->code,
                'amount' => $data['amount'],
                'network_code' => $data['network_code'],
                'type' => LoanTypeEnum::tryFrom($data['type']),
                'status' =>  LoanPaymentStatusEnum::UN_PAID,
                'shift_id' => $shiftId,
                'code' => generateCode(name:  time(), prefixText: $data['network_code']),
                'notes'  => $data['notes']
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

        // till for the opened shift

        $tillCheck  = ShiftNetwork::query()
            ->whereHas('shift', fn($query) => $query->where('status', ShiftStatusEnum::OPEN))
            ->where('network_code', $data['till_code']);


        if (! $tillCheck->exists())
        {
            throw  new  \Exception("You cannot transact without an open shift");

        }

        $till = $tillCheck
            ->with('shift')
            ->first();


        // increase cash

        $newBalance = $till->balance_new;

        $cash = $till->shift->cash_end;

        /** @var Shift $shift */
        $shift = $till->shift;

        $shift->updateQuietly([
            'cash_start' => $cash ,
            'cash_end' => $cash + floatval($data['amount']),
        ]);

        $till->updateQuietly([
            'balance_new' => $newBalance -  floatval($data['amount']),
            'balance_old' => $newBalance
        ]);

        $shift->refresh();


        return  [
            $shift->cash_end,
            $shift->cash_start,
        ];

    }

    // reduce cash and increase till float
    private static function moneyOut(array $data): array {


        // till for the opened shift

        $tillCheck  = ShiftNetwork::query()
            ->whereHas('shift', fn($query) => $query->where('status', ShiftStatusEnum::OPEN))
            ->where('network_code', $data['till_code']);


        if (! $tillCheck->exists())
        {
            throw  new  \Exception("You cannot transact without an open shift");

        }

        $till = $tillCheck
            ->with('shift')
            ->first();


        // increase cash

        $newBalance = $till->balance_new;

        /** @var Shift $shift */
        $shift = $till->shift;

        $cash = $till->shift->cash_end;

        $cashEnd = $cash -  floatval($data['amount']);


        $shift->updateQuietly([
            'cash_start' => floatval($cash) ,
            'cash_end' =>  floatval($cashEnd),
        ]);


        $till->updateQuietly([
            'balance_old' => $newBalance,
            'balance_new' => $newBalance +  floatval($data['amount'])
        ]);


        $shift->refresh();


        return  [
            $shift->cash_end,
            $shift->cash_start,
        ];


    }




}

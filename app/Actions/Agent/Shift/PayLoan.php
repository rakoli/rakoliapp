<?php

namespace App\Actions\Agent\Shift;

use App\Events\Shift\LoanPaidEvent;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Models\Transaction;
use App\Utils\Enums\LoanPaymentStatusEnum;
use App\Utils\Enums\LoanTypeEnum;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class PayLoan
{
    use  AsAction;

    /**
     * @throws \Throwable
     */
    public function handle(Loan $loan , array $data)
    {

        try {


           throw_if(condition:  ! Shift::query()->where('status', ShiftStatusEnum::OPEN)->exists(),
               // exception: new \Exception("You cannot transact without an open shift")
            );


            DB::beginTransaction();


            /** @var LoanPayment $payment */

            $payment = $loan->payments()
                ->create([
                   'user_code' => auth()->user()->code,
                   'amount' => $data['amount'],
                   'description' => $data['description'] ?? null,
                   'notes' => $data['notes'] ?? null,
                   'payment_method' => $data['payment_method'] ?? null,
                   'deposited_at' => Carbon::parse($data['deposited_at']),
                ]);


            event(new LoanPaidEvent(payment: $payment));


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

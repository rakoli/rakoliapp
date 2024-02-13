<?php

namespace App\Actions\Agent\Shift;

use App\Events\Shift\LoanPaidEvent;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\Shift;
use App\Utils\Enums\LoanPaymentStatusEnum;
use App\Utils\Enums\LoanTypeEnum;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class PayLoanAction
{
    use AsAction;

    use InteractsWithShift;

    /**
     * @param  array{amount: float, description: ?string, notes: ?string , payment_method: ?string, deposited_at: string}  $data
     *
     * @throws \Throwable
     */
    public function handle(Loan $loan, array $data)
    {
        return runDatabaseTransaction(function () use ($loan, $data) {

            throw_if(condition: ($loan->payments()->sum('amount') + $data['amount']) > $loan->amount,
                exception: new \Exception(__('You cannot receive more than loan balance'))
            );

            $currentShift = Shift::query()
                ->where([
                    'location_code' => $loan->location_code,
                    'business_code' => $loan->business_code,
                    'status' => ShiftStatusEnum::OPEN
                ]);


            if ( ! $currentShift->exists())
            {
                throw new \Exception("You must have an active shift to recive this payment ");
            }


            /** @var LoanPayment $payment */
            $payment = LoanPayment::create([
                'loan_code' => $loan->code,
                'user_code' => auth()->user()->code,
                'amount' => $data['amount'],
                'description' => $data['description'] ?? null,
                'notes' => $data['notes'] ?? null,
                'payment_method' => $data['payment_method'] ?? null,
                'deposited_at' => Carbon::parse($data['deposited_at']),
            ]);

            $currentShift = $currentShift->first();


            $shiftBalances = shiftBalances(shift: $currentShift);


            $oldBalance = collect($shiftBalances['networks'])->where('code', $loan->network_code)->first();


            $data['network_code'] = $loan->network_code;
            $data['category'] = TransactionCategoryEnum::GENERAL;
            $data['description'] = "Loan Repayment {$loan->type->label()} transaction on: {$loan->created_at->format('Y-m-d')}";
            $data['type'] = LoanTypeEnum::MONEY_OUT ? TransactionTypeEnum::MONEY_OUT : TransactionTypeEnum::MONEY_IN;

            if ($loan->type == LoanTypeEnum::MONEY_OUT)
            {
                $newBalance =  $oldBalance['balance'] + $data['amount'];
            }
           else
           {
               $newBalance =  $oldBalance['balance'] - $data['amount'];
           }


            $this->createShiftTransaction(
                shift: $currentShift,
                data:  $data,
                oldBalance: $oldBalance['balance'],
                newBalance:   $newBalance
            );



            $loan->refresh();

            if ($loan->paid != $loan->amount) {
                $loan->updateQuietly([
                    'status' => LoanPaymentStatusEnum::PARTIALLY,
                ]);
            } else {
                $loan->updateQuietly([
                    'status' => LoanPaymentStatusEnum::FULL_PAID,
                ]);
            }

            event(new LoanPaidEvent(payment: $payment));

        });
    }
}

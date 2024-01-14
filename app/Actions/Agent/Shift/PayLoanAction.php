<?php

namespace App\Actions\Agent\Shift;

use App\Events\Shift\LoanPaidEvent;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Utils\Enums\LoanPaymentStatusEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class PayLoanAction
{
    use AsAction;

    /**
     * @param  array{amount: float, description: ?string, notes: ?string , payment_method: ?string, deposited_at: string}  $data
     *
     * @throws \Throwable
     */
    public function handle(Loan $loan, array $data)
    {

        try {

            throw_if(condition: ($loan->payments()->sum('amount') + $data['amount']) > $loan->amount,
                exception: new \Exception(__('You cannot receive more than loan balance'))
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

            $loan->refresh();

            if ($loan->payments()->sum('amount') != $loan->amount) {
                $loan->updateQuietly([
                    'status' => LoanPaymentStatusEnum::PARTIALLY,
                ]);
            } else {
                $loan->updateQuietly([
                    'status' => LoanPaymentStatusEnum::FULL_PAID,
                ]);
            }

            event(new LoanPaidEvent(payment: $payment));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}

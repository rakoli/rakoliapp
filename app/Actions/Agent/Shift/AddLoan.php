<?php

namespace App\Actions\Agent\Shift;

use App\Models\Loan;
use App\Models\Shift;
use App\Models\Transaction;
use App\Utils\Enums\LoanPaymentStatusEnum;
use App\Utils\Enums\LoanTypeEnum;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class AddLoan
{
    use AsAction;

    use InteractsWithShift;

    /**
     * @throws \Throwable
     */
    public function handle(array $data)
    {

        try {

            throw_if(condition: ! Shift::query()->where('status', ShiftStatusEnum::OPEN)->exists(),
                exception: new \Exception('You cannot transact without an open shift')
            );

            DB::beginTransaction();

            $shift = Shift::query()->where('status', ShiftStatusEnum::OPEN)->first();

            Loan::create([
                'business_code' => auth()->user()->business_code,
                'location_code' => $data['location_code'],
                'user_code' => auth()->user()->code,
                'amount' => $data['amount'],
                'network_code' => $data['network_code'],
                'type' => LoanTypeEnum::tryFrom($data['type']),
                'status' => LoanPaymentStatusEnum::UN_PAID,
                'shift_id' => $shift->id,
                'code' => generateCode(name: time(), prefixText: $data['network_code']),
                'notes' => $data['notes'],
            ]);



            /*Transaction::create([
                'business_code' => $shift->business_code,
                'location_code' => $shift->location_code,
                'user_code' => auth()->user()->code,
                'amount' => $data['amount'],
                'amount_currency' => currencyCode(),
                'type' => $data['type'],
                'category' => $data['category'],
                'balance_old' => 0,
                'balance_new' => 0,
                'description' => $data['notes'],
            ]);

            $this->createShiftTransaction(
                shift: $shift,
                data: $data,
                oldBalance: 0,
                newBalance: 0
            );*/




            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }
}

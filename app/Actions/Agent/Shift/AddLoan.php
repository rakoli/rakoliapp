<?php

namespace App\Actions\Agent\Shift;

use App\Models\Loan;
use App\Models\Shift;
use App\Utils\Enums\LoanPaymentStatusEnum;
use App\Utils\Enums\LoanTypeEnum;
use App\Utils\Enums\ShiftStatusEnum;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class AddLoan
{
    use AsAction;

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

            $shiftId = Shift::query()->where('status', ShiftStatusEnum::OPEN)->first(['id'])?->id;

            Loan::create([
                'business_code' => auth()->user()->business_code,
                'location_code' => $data['location_code'],
                'user_code' => auth()->user()->code,
                'amount' => $data['amount'],
                'network_code' => $data['network_code'],
                'type' => LoanTypeEnum::tryFrom($data['type']),
                'status' => LoanPaymentStatusEnum::UN_PAID,
                'shift_id' => $shiftId,
                'code' => generateCode(name: time(), prefixText: $data['network_code']),
                'notes' => $data['notes'],
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }
}

<?php

namespace App\Actions\Agent\Shift;

use App\Models\Shift;
use App\Models\ShiftTransferRequest;
use App\Utils\Enums\ShiftTransferRequestStatusEnum;
use Lorisleiva\Actions\Concerns\AsAction;

class AddShiftTransferRequestAction
{
    use AsAction;

    public function handle(Shift $shift, array $data)
    {

        return runDatabaseTransaction(function () use ($shift, $data) {

            if (ShiftTransferRequest::query()->where('status', '!=',ShiftTransferRequestStatusEnum::REJECTED)->exists()) {
                throw new \Exception('Already, Transfer request has been created.');
            }
            // @todo check allowed no of shift for this business per day

            ShiftTransferRequest::create([
                'user_code' => $data['transfer_user_code'],
                'business_code' => auth()->user()->business_code,
                'location_code' => $shift->location_code,
                'shift_id' => $shift->id,
                'note' => $data['notes'],
                'description' => $data['description'],
            ]);

        });

    }
}

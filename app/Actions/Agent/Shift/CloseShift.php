<?php

namespace App\Actions\Agent\Shift;

use App\Events\Shift\ShitClosedEvent;
use App\Models\Network;
use App\Models\Shift;
use App\Utils\Enums\ShiftStatusEnum;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class CloseShift
{
    use AsAction;

    public function handle(float $closingBalance, string $locationCode, ?string $notes = null, ?array $tills = [])
    {

        try {
            DB::beginTransaction();

            $shift = Shift::query()->latest('created_at')
                ->where('location_code', $locationCode)
                ->where('status', ShiftStatusEnum::OPEN)->first();

            $shift->updateQuietly([
                'cash_end' => $closingBalance,
                'status' => ShiftStatusEnum::CLOSED,
                'notes' => str($shift->note)->append(" $notes")->toString(),
            ]);

            foreach ($tills as $tillCode => $amount) {

                Network::query()
                    ->where([
                        'code' => $tillCode,
                    ])
                    ->first()
                    ->updateQuietly([
                        'balance' => floatval($amount),
                    ]);

            }

            DB::commit();

            event(new ShitClosedEvent(shift: $shift));

        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception($e->getMessage());
        }

    }
}

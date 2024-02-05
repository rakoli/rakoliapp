<?php

namespace App\Actions\Agent\Shift;

use App\Events\Shift\ShiftClosedEvent;
use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Utils\Enums\ShiftStatusEnum;
use Lorisleiva\Actions\Concerns\AsAction;

class CloseShift
{
    use AsAction;

    public function handle(float $closingCash, string $locationCode, ?string $notes = null, ?string $description = null, ?array $tills = [])
    {

        return runDatabaseTransaction(function () use ($closingCash, $locationCode, $notes, $description, $tills) {

            $shift = Shift::query()->latest('created_at')
                ->where('location_code', $locationCode)
                ->where('status', ShiftStatusEnum::OPEN)->first();

            $shift->updateQuietly([
                'cash_end' => $closingCash,
                'status' => ShiftStatusEnum::CLOSED,
                'description' => str($shift->description)->append(" $description")->toString(),
                'notes' => str($shift->note)->append(" $notes")->toString(),
            ]);

            Location::query()
                ->where('code', $locationCode)
                ->first()
                ->updateQuietly([
                    'balance' => $closingCash
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

            event(new ShiftClosedEvent(shift: $shift));

        });

    }
}

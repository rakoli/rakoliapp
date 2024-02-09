<?php

namespace App\Http\Controllers\Agent\Shift;

use App\Models\Shift;
use App\Utils\Enums\ShiftStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TransferShiftController extends CloseShiftController
{
    public function store(Shift $shift, Request $request)
    {

        $validated = $this->validateForm($request);

        $validated['status'] = ShiftStatusEnum::INREVIEW;

        try {

            // throw_if(! Shift::query()->where('status', ShiftStatusEnum::OPEN)->exists(), new \Exception("No open shift to close"));

            \App\Actions\Agent\Shift\CloseShift::run(
                shift: $shift,
                data: $validated
            );

            return response()
                ->json([
                    'message' => 'Closed Shift successfully',
                ], 200);

        } catch (ValidationException|\Throwable|\Exception $e) {
            return response()
                ->json([
                    'message' => $e->getMessage(),
                ], 422);
        }

    }
}

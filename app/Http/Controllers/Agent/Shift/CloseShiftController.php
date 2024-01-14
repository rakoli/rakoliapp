<?php

namespace App\Http\Controllers\Agent\Shift;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Utils\Enums\ShiftStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CloseShiftController extends Controller
{
    public function index()
    {

        if (! Shift::query()->where('status', ShiftStatusEnum::OPEN)->exists()) {
            return to_route('agency.shift');
        }

        $tills = Network::query()->with('agency')->cursor();
        $locations = Location::query()->cursor();

        $shift = Shift::query()->where('status', ShiftStatusEnum::OPEN)->first();

        return view('agent.agency.close-shift')->with([
            'tills' => $tills,
            'locations' => $locations,
            'shift' => $shift,
        ]);
    }

    public function store(Request $request)
    {
        abort_if(! Shift::query()->where('status', ShiftStatusEnum::OPEN)->exists(), 404, 'No open shift to close');

        try {
            $validated = $request->validate(rules: [
                'closing_balance' => 'required|numeric',
                'location_code' => 'required',
                'notes' => 'required',
                'tills' => 'required|array',
            ]);

            \App\Actions\Agent\Shift\CloseShift::run(
                closingBalance: $validated['closing_balance'],
                locationCode: $validated['location_code'],
                notes: $validated['notes'],
                tills: $validated['tills']
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

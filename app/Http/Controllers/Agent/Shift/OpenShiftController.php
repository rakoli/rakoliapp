<?php

namespace App\Http\Controllers\Agent\Shift;

use App\Actions\Agent\Shift\OpenShift;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Utils\Enums\ShiftStatusEnum;
use Illuminate\Http\Request;

class OpenShiftController extends Controller
{
    public function index()
    {

        if (Shift::query()->where('status', ShiftStatusEnum::OPEN)->exists()) {
            return to_route('agency.shift');
        }
        $tills = Network::query()->with('agency')->cursor();

        $locations = Location::query()
            // ->whereHas('users', fn($query) => $query->where('user_code', auth()->user()->code)) //@todo Remove this when implemented
            ->cursor();

        return view('agent.agency.shift.open-shift', [
            'tills' => $tills,
            'locations' => $locations,
        ]);
    }

    public function store(Request $request)
    {

        //validate

        $validated = $request->validate([
            'location_code' => 'required|exists:locations,code',
            'description' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        try {

            OpenShift::run(
                cashAtHand: Location::query()->where('code', $validated['location_code'])->pluck('balance')->first(),
                locationCode: $validated['location_code'],
                notes: $validated['notes'],
                description: $validated['description']
            );

            return response()
                ->json([
                    'message' => 'Successfully opened a new shift',
                ], 201);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'message' => $e->getMessage(),
                ], 422);
        }

    }
}

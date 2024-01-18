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


        if ( Shift::query()->where('status', ShiftStatusEnum::OPEN)->exists())
        {
            return  to_route('agency.shift')->withErrors([
                'error' => "cannot Open another shift"
            ]);
        }
        $tills = Network::query()->with('agency')->cursor();

        $locations = Location::query()->cursor();


        return view('agent.agency.shift.open-shift',[
            'tills' => $tills,
            'locations' => $locations,
        ]);
    }
    public function store(Request $request)
    {

        //validate

        $validated = $request->validate([
            'cash_at_hand' => 'required|numeric',
            'location_code' => 'required|exists:locations,code',
            'notes' => 'required|string',
        ], [
            'network_code.required',
        ]);

        try {

            OpenShift::run(
                cashAtHand: $validated['cash_at_hand'],
                locationCode: $validated['location_code'],
                notes: $validated['notes']
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

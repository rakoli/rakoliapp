<?php

namespace App\Http\Controllers\Agent\Shift;

use App\Actions\Agent\Shift\OpenShift;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OpenShiftController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
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

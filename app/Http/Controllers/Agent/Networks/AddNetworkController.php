<?php

namespace App\Http\Controllers\Agent\Networks;

use App\Actions\Agent\Shift\Network\AddLocationNetwork;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddNetworkController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'agent_no' => 'required',
            'fsp_code' => 'required',
            'balance' => 'required|numeric',
            'description' => 'nullable|string',
            'location_code' => 'required|exists:locations,code',
        ], [
            'fsp_code.required' => 'Financial service provider is required',
            'balance.required' => 'Till balance is required',
            'location_code.required' => 'Location is required',
            'location_code.exists' => 'Location does not exist',
        ]);

        try {

            AddLocationNetwork::run($validated);

            return response()
                ->json([
                    'message' => 'Network Added successfully',
                ], 201);

        } catch (\Exception $e) {
            return response()
                ->json([
                    'message' => $e->getMessage(),
                ], 422);

        }
    }
}

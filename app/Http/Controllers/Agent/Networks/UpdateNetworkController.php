<?php

namespace App\Http\Controllers\Agent\Networks;

use App\Actions\Agent\Shift\Network\UpdateLocationNetwork;
use App\Http\Controllers\Controller;
use App\Models\Network;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateNetworkController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Network $network)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'agent_no' => [
                'required',
                Rule::unique('networks', 'agent_no')
                    ->whereNull('deleted_at')
                    ->ignore($network->id),
            ],
            'fsp_code' => [
                'required',
            ],
            'description' => 'nullable|string',
            'balance' => 'required|numeric',
            'location_code' => 'required|exists:locations,code',
        ], [
            'fsp_code.required' => 'Financial service provider is required',
            'balance.required' => 'Till balance is required',
            'location_code.required' => 'Location is required',
            'location_code.exists' => 'Location does not exist',
        ]);

        try {
            UpdateLocationNetwork::run(
                network: $network,
                data: $validated
            );

            return response()
                ->json([
                    'message' => 'Network Updated successfully',
                ], 201);

        } catch (\Exception $e) {
            return response()
                ->json([
                    'message' => $e->getMessage(),
                ], 422);

        }
    }
}

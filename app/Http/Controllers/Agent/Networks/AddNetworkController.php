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
            'type' => 'required',
            'agent_no' => 'required_if:type,Finance',
            'fsp_code' => 'required_if:type,Finance',
            'crypto_code' => 'required_if:type,Crypto',
            'balance' => 'required_if:type,Finance|nullable|numeric',
            'crypto_balance' => 'required_if:type,Crypto|nullable|numeric',
            'exchange_rate' => 'required_if:type,Crypto|nullable|numeric',
            'description' => 'nullable|string',
            'location_code' => 'required|exists:locations,code',
        ], [
            'fsp_code.required' => 'Financial service provider is required',
            'crypto_code.required' => 'Crypto provider is required',
            'type.required' => 'Network type is required',
            'balance.required' => 'Till balance is required',
            'crypto_balance.required' => 'Crypto balance is required',
            'exchange_rate.required' => 'Exchange Rate is required',
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

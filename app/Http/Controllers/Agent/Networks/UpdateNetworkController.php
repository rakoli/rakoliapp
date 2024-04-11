<?php

namespace App\Http\Controllers\Agent\Networks;

use App\Actions\Agent\Shift\Network\UpdateLocationNetwork;
use App\Http\Controllers\Controller;
use App\Models\Network;
use App\Models\ShiftTransaction;
use App\Models\Transaction;
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
            'type' => 'required',
            'agent_no' => [
                'required',
                Rule::unique('networks')
                    ->whereNull('deleted_at')
                    ->whereNot('id', $network->id)
                    ->where('fsp_code', $network->fsp_code)
                    ->ignore($network->id,'id'),
            ],
            'fsp_code' => [
                'required',
            ],
            'description' => 'nullable|string',
            'balance' => 'required|numeric',
            'location_code' => 'required|exists:locations,code',
        ], [
            'fsp_code.required' => 'Financial service provider is required',
            'type.required' => 'Network type is required',
            'balance.required' => 'Till balance is required',
            'location_code.required' => 'Location is required',
            'location_code.exists' => 'Location does not exist',
        ]);

        try {

            if ( ShiftTransaction::query()->whereBelongsTo($network, 'network')->exists()
                &&
                $network->balance != $validated['balance']
            )
            {
                throw new \Exception(__("Cannot update till balance with a transaction "));
            }
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

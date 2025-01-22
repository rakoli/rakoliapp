<?php

namespace App\Http\Controllers\Agent\Networks;

use App\Actions\Agent\Shift\Network\AddLocationNetwork;
use App\Http\Controllers\Controller;
use App\Models\Network;
use App\Utils\Enums\NetworkTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AddNetworkController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if(!validateSubscription("tills",Network::where('location_code', $request->location_code)->count())){
            return response()->json([
                'message' => "You have exceeded network limit, Please upgrade your plan",
            ], 403);
        }

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

            $type = NetworkTypeEnum::tryFrom($request->type);
            if($type === NetworkTypeEnum::CRYPTO){
                $networkCheck = Network::query()
                ->where([
                    'location_code' => $request->location_code,
                    'crypto_code' => $request->crypto_code,
                ])
                ->exists();
            } else {
                $networkCheck = Network::query()
                ->where([
                    'location_code' => $request->location_code,
                    'fsp_code' => $request->fsp_code,
                    'agent_no' => $request->agent_no,
                ])
                ->exists();
            }

            if($networkCheck){
                return response()
                ->json([
                    'message' => "Network already exists.",
                ], 422);
            }
            
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

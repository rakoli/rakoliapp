<?php

namespace App\Http\Controllers\Agent\Networks;

use App\Http\Controllers\Controller;
use App\Models\FinancialServiceProvider;
use App\Models\Location;
use App\Models\Network;
use Illuminate\Http\Request;

class ShowNetworkController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {

        $network = Network::query()->where('id', $id)->first();

        if (! isset($network->id) && ! $request->ajax()) {
            return to_route('agency.networks');
        }
        if (! isset($network->id) && $request->ajax()) {
            return response()
                ->json([
                    'message' => 'Network not found',
                ], 404);
        }

        $locations = Location::query()->cursor();

        $fsps = FinancialServiceProvider::query()->cursor();

        return view('agent.agency.network.show', [
            'network' => $network->loadMissing('agency', 'location'),
            'locations' => $locations,
            'agencies' => $fsps,
        ]);
    }
}

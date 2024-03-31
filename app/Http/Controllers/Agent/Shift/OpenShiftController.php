<?php

namespace App\Http\Controllers\Agent\Shift;

use App\Actions\Agent\Shift\OpenShift;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Utils\Enums\ShiftStatusEnum;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;

class OpenShiftController extends Controller
{
    public function index()
    {

        if (Shift::query()->where('status', ShiftStatusEnum::OPEN)->exists()) {
            return to_route('agency.shift');
        }

        $locations = Location::query()
            ->whereHas('users', fn($query) => $query->where('user_code', auth()->user()->code))
            ->with([
                'networks.agency'])
            ->get()
        ->map( fn(Location $location) : array => [
            'name' => $location->name,
            'balance' => $location->balance,
            'code' => $location->code,
            'networks' => $location->networks->map(fn(Network $network) : array => [
                'name' => $network->agency->name,
                'balance' => $network->balance
            ]),
        ]);

        return view('agent.agency.shift.open-shift', [
            'locations' => $locations,
        ]);
    }

    public function store(Request $request)
    {
        $nos = Shift::query()->latest('created_at')
        ->whereDate('created_at', Carbon::tomorrow())
        ->first()?->no;

        if(!validateSubscription("shift tracking",$nos)){
            return response()->json([
                'message' => "You have exceeded shift limit, Please upgrade your plan",
            ], 403);
        }

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

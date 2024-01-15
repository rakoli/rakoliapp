<?php

namespace App\Http\Controllers\Agent\Networks;

use App\Http\Controllers\Controller;
use App\Models\Network;
use Illuminate\Http\Request;

class DeleteNetworkController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Network $network)
    {

        try {

         /*   throw_if(
                condition:  "DELETE" != $request->name ,
                exception: new \Exception("Network name do not match")
            );*/

            $network->delete();

            return response()
                ->json([
                    'message' => 'Network Updated successfully',
                ], 200);

        }catch (\Exception $exception)
        {
            return response()
                ->json([
                    'message' => $exception->getMessage(),
                ], 422);

        }
    }
}

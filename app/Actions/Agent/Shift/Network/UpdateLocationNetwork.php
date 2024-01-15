<?php

namespace App\Actions\Agent\Shift\Network;

use App\Models\Network;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateLocationNetwork
{
    use AsAction;

    /**
     * @param  array{location_code:string , fsp_code:string,name:string , agent_no: string , balance:float , notes: string }  $data
     *
     * @throws \Exception
     */
    public function handle(Network $network, array $data): Network
    {
        try {

            $network->updateQuietly([
                'location_code' => $data['location_code'],
                'fsp_code' => $data['fsp_code'],
                'agent_no' => $data['agent_no'],
                'balance' => $data['balance'],
                'balance_currency' => currencyCode(),
                'name' => $data['name'],
                'description' => $data['notes'],
            ]);

            return $network;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }
}

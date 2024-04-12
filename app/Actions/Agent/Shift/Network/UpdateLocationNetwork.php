<?php

namespace App\Actions\Agent\Shift\Network;

use App\Models\Network;
use App\Utils\Enums\NetworkTypeEnum;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateLocationNetwork
{
    use AsAction;

    /**
     * @param  array{location_code:string , fsp_code:string,name:string , agent_no: string , balance:float , description: ?string }  $data
     *
     * @throws \Exception
     */
    public function handle(Network $network, array $data): Network
    {

        return runDatabaseTransaction(function () use ($network, $data) {

            $network->updateQuietly([
                'location_code' => $data['location_code'],
                'type' => NetworkTypeEnum::tryFrom($data['type']),
                'fsp_code' => $data['fsp_code'],
                'agent_no' => $data['agent_no'],
                'balance' => $data['balance'],
                'balance_currency' => currencyCode(),
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]);

            return $network;

        });

    }
}

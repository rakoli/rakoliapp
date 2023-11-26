<?php

namespace App\Actions\Agent\Shift;

use App\Events\Shift\NetworkCreatedEvent;
use App\Models\Network;
use Lorisleiva\Actions\Concerns\AsAction;

class AddLocationNetwork
{

    use AsAction;


    /**
     * @param array $data
     * @return void
     * @throws \Throwable
     */
    public function handle(array $data): void
    {
        try {

            $networkCheck = Network::query()
                ->where([
                    'location_code' => $data['location_code'],
                    'fsp_code' => $data['fsp_code'],
                    'agent_no' => $data['agent_no'],
                ])
                ->exists();


            throw_if($networkCheck, new \Exception("Network exists with the same details in this location"));

            $network =  Network::create([
                'business_code' => auth()->user()->business_code,
                'location_code' => $data['location_code'],
                'fsp_code' => $data['fsp_code'],
                'code' => generateCode(name: $data['name'], prefixText: $data['fsp_code']),
                'agent_no' => $data['agent_no'],
                'balance' => $data['balance'],
                'balance_currency' => currencyCode(),
                'name' => $data['name'],
                'description' => $data['notes'],
            ]);

            event(new NetworkCreatedEvent(network: $network));

        }catch (\Exception $e)
        {
            throw new \Exception($e->getMessage());
        }

    }
}

<?php

namespace App\Actions\Agent\Shift\Network;

use App\Events\Shift\NetworkCreatedEvent;
use App\Models\Network;
use App\Utils\Enums\NetworkTypeEnum;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class AddLocationNetwork
{
    use AsAction;

    /**
     * @param  array{location_code:string , fsp_code:string,name:string , agent_no: string , balance:float , description: ?string }  $data
     *
     * @throws \Throwable
     */
    public function handle(array $data): mixed
    {

        try {
            return runDatabaseTransaction(function () use ($data) {
                Log::info("AddLocationNetwork :: Request Data :: ".print_r($data,true));

                $type = NetworkTypeEnum::tryFrom($data['type']);
                if($type === NetworkTypeEnum::CRYPTO){
                    Log::info("AddLocationNetwork :: Crypto Network");

                    $network = Network::create([
                        'business_code' => auth()->user()->business_code,
                        'location_code' => $data['location_code'],
                        'type' => $type,
                        'crypto_code' => $data['crypto_code'],
                        'code' => generateCode(name: $data['name'], prefixText: $data['fsp_code']),
                        'agent_no' => generateCode(name: $data['name'], prefixText: $data['crypto_code']),
                        'crypto_balance' => $data['crypto_balance'],
                        'exchange_rate' => $data['exchange_rate'],
                        'name' => $data['name'],
                        'description' => $data['description'] ?? null,
                    ]);

                } else {
                    Log::info("AddLocationNetwork :: Till Network");

                    $networkCheck = Network::query()
                    ->where([
                        'location_code' => $data['location_code'],
                        'fsp_code' => $data['fsp_code'],
                        'agent_no' => $data['agent_no'],
                    ])
                    ->exists();

                    throw_if($networkCheck, new \Exception('Network exists with the same details in this location'));

                    $network = Network::create([
                        'business_code' => auth()->user()->business_code,
                        'location_code' => $data['location_code'],
                        'type' => $type,
                        'fsp_code' => $data['fsp_code'],
                        'code' => generateCode(name: $data['name'], prefixText: $data['fsp_code']),
                        'agent_no' => $data['agent_no'] ?? null,
                        'balance' => $data['balance'] ?? null,
                        'balance_currency' => currencyCode(),
                        'name' => $data['name'],
                        'description' => $data['description'] ?? null,
                    ]);
                }
                Log::info("AddLocationNetwork :: Added Network :: ".print_r($network,true));

                // event(new NetworkCreatedEvent(network: $network));
            });
        }catch (\Exception $exception)
        {
            Log::info("AddLocationNetwork :: Exception :: ".print_r($exception->getMessage(),true));
            throw new \Exception($exception->getMessage());
        }

    }
}

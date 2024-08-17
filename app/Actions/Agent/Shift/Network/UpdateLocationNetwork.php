<?php

namespace App\Actions\Agent\Shift\Network;

use App\Models\Network;
use App\Utils\Enums\NetworkTypeEnum;
use Illuminate\Support\Facades\Log;
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
        try {
            return runDatabaseTransaction(function () use ($network, $data) {
                Log::info("UpdateLocationNetwork :: Request Data :: ".print_r($data,true));

                $type = NetworkTypeEnum::tryFrom($network->type);
                if($type === NetworkTypeEnum::CRYPTO){
                    Log::info("UpdateLocationNetwork :: Crypto Network");

                    $network->updateQuietly([
                        'location_code' => $data['location_code'],
                        'crypto_balance' => $data['crypto_balance'],
                        'exchange_rate' => $data['exchange_rate'],
                        'name' => $data['name'],
                        'description' => $data['description'] ?? null,
                    ]);
                } else {
                    Log::info("UpdateLocationNetwork :: Till Network");

                    $network->updateQuietly([
                        'location_code' => $data['location_code'],
                        'fsp_code' => $data['fsp_code'],
                        'agent_no' => $data['agent_no'],
                        'balance' => $data['balance'],
                        'balance_currency' => currencyCode(),
                        'name' => $data['name'],
                        'description' => $data['description'] ?? null,
                    ]);    
                }
                Log::info("UpdateLocationNetwork :: Updated Network :: ".print_r($network,true));

                return $network;

            });
        }catch (\Exception $exception)
        {
            Log::info("UpdateLocationNetwork :: Exception :: ".print_r($exception->getMessage(),true));
            throw new \Exception($exception->getMessage());
        }
    }
}

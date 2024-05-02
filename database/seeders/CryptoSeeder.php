<?php

namespace Database\Seeders;

use App\Models\Crypto;
use App\Models\Region;
use App\Models\Towns;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CryptoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = null;
        $apiData = Crypto::getCryptoList();
        if($apiData == false || !array_key_exists('data',$apiData)){
            $data = require_once __DIR__.'/seeds/crypto.php';
        }else{
            $data = $apiData['data'];
        }

        foreach ($data as $crypto) {
            Crypto::create([
                'code' => $crypto['id'],
                'rank' => $crypto['rank'],
                'symbol' => $crypto['symbol'],
                'name' => $crypto['name'],
                'usd_rate' => round($crypto['priceUsd'], 8),
            ]);
        }
    }
}

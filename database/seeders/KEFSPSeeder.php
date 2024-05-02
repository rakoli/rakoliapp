<?php

namespace Database\Seeders;

use App\Models\FinancialServiceProvider;
use Illuminate\Database\Seeder;

class KEFSPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = require_once __DIR__.'/seeds/kefsp.php';

        foreach ($data as $fsp) {

            $data = [
                'country_code' => 'KE',
                'name' => strtoupper($fsp['name']),
                'code' => generateCode($fsp['name'], 'ke'),
            ];

            if(in_array($fsp['name'],FinancialServiceProvider::$keDefaultsFSPs)){
                $data['is_default'] = true;
            }

            FinancialServiceProvider::create($data);

        }
    }
}

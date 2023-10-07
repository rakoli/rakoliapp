<?php

namespace Database\Seeders;

use App\Models\FinancialServiceProvider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TZFSPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = require_once __DIR__ . '/seeds/tzfsp.php';

        foreach ($data as $fsp) {

            FinancialServiceProvider::create([
                'country_code' => 'TZ',
                'name' => $fsp['name'],
                'code' => generateCode($fsp['name'],"tz"),
            ]);

        }

    }
}

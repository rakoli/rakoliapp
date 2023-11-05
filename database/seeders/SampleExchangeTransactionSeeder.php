<?php

namespace Database\Seeders;

use App\Models\ExchangeTransaction;
use App\Models\Shift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleExchangeTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExchangeTransaction::factory()->count(7)->create();

    }
}

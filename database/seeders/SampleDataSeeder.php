<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            SampleSystemIncomeSeeder::class,
            SampleExchangeAdsSeeder::class,
            SampleVasTaskSeeder::class,
            SampleVasContractSeeder::class,
            SampleVasPaymentSeeder::class,
            SampleVasSubmissionSeeder::class,
        ]);
    }
}

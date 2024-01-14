<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            SampleBusinessSeeder::class,
            SampleSystemIncomeSeeder::class,
            SampleExchangeAdsSeeder::class,
            SampleVasTaskSeeder::class,
            SampleVasContractSeeder::class,
            SampleVasPaymentSeeder::class,
            SampleVasSubmissionSeeder::class,
            SampleTransactionSeeder::class,
            SampleNetworkSeeder::class,
            SampleShiftSeeder::class,
            SampleExchangeTransactionSeeder::class,
        ]);
    }
}

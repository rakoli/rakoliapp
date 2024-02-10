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
        if (env('APP_ENV') != 'production'){
            $this->call([
                SampleBusinessSeeder::class,
                SampleReferralBusinessSeeder::class,
                SampleSystemIncomeSeeder::class,
//            SampleExchangeAdsSeeder::class, //In Business Seeder, PUT OF FOR OTHER TESTINGS
                SampleVasTaskSeeder::class,
                SampleVasContractSeeder::class,
                SampleVasPaymentSeeder::class,
                SampleVasSubmissionSeeder::class,
                SampleTransactionSeeder::class,
                SampleNetworkSeeder::class,
                SampleShiftSeeder::class,
//            SampleExchangeTransactionSeeder::class, //In Business Seeder
            ]);
        }

    }
}

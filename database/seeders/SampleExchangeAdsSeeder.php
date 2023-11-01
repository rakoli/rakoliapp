<?php

namespace Database\Seeders;

use App\Models\ExchangeAds;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleExchangeAdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExchangeAds::factory()->count(15)->create();

    }
}

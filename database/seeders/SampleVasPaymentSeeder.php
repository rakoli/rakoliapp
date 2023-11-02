<?php

namespace Database\Seeders;

use App\Models\VasContract;
use App\Models\VasPayment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleVasPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VasPayment::factory()->count(3)->create();

    }
}

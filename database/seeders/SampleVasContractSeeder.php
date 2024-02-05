<?php

namespace Database\Seeders;

use App\Models\VasContract;
use Illuminate\Database\Seeder;

class SampleVasContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VasContract::factory()->count(5)->create();

    }
}

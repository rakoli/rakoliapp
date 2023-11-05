<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\SystemIncome;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Business::factory()->count(8)->create();
    }
}

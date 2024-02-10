<?php

namespace Database\Seeders;

use App\Models\SystemIncome;
use Illuminate\Database\Seeder;

class SampleSystemIncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemIncome::factory()->count(12)->create();
    }
}

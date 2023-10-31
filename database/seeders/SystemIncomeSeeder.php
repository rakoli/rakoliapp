<?php

namespace Database\Seeders;

use App\Models\SystemIncome;
use Database\Factories\SystemIncomeFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemIncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemIncome::factory()->count(12)->create();
    }
}

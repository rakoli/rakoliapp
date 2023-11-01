<?php

namespace Database\Seeders;

use App\Models\VasTask;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleVasTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VasTask::factory()->count(24)->create();
    }
}

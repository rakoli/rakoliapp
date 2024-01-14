<?php

namespace Database\Seeders;

use App\Models\VasSubmission;
use Illuminate\Database\Seeder;

class SampleVasSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VasSubmission::factory()->count(3)->create();
    }
}

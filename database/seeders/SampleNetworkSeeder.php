<?php

namespace Database\Seeders;

use App\Models\Network;
use Illuminate\Database\Seeder;

class SampleNetworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Network::factory()->count(6)->create();
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingsSeeder::class,
            CountrySeeder::class,
            PackagesTableSeeder::class,
            UsersTableSeeder::class,
            TZFSPSeeder::class,
            KEFSPSeeder::class,
            TzRegionTableSeeder::class,
            KeRegionTableSeeder::class,
            WardsSeeder::class,
            SampleDataSeeder::class,
        ]);
    }
}

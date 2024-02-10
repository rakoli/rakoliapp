<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'app_description' => 'Rakoli agents management system web application',
        ];

        foreach ($settings as $key => $setting) {

            Setting::updateOrCreate([
                'key' => $key,
            ], [
                'value' => $setting,
            ]);

        }
    }
}

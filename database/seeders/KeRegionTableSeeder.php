<?php
/**************************************************************************
 * Copyright (C) don, Inc - All Rights Reserved
 *
 * @file        KeRegionTableSeeder.php
 * @author      don
 * @site        <donphelix.com>
 * @date        09/08/2023
 */


namespace Database\Seeders;

use App\Models\Region;
use App\Models\Towns;
use App\Utils\Helpers;
use Illuminate\Database\Seeder;

class KeRegionTableSeeder extends Seeder
{
    public function run(): void
    {
        $data = require_once __DIR__ . '/seeds/kelocations.php';

        foreach ($data as $regionData) {
            $region = Region::create([
                'country_code' => 'KE',
                'name' => $regionData['name'],
                'code' => "KE_".cleanText($regionData['name']),
            ]);

            foreach ($regionData['sub_counties'] as $subCountyName) {
                Towns::create([
                    'country_code' => 'KE',
                    'region_code' => $region->code,
                    'name' => $subCountyName,
                    'code'=> $region->code."_".cleanText($subCountyName),
                ]);
            }
        }
    }
}

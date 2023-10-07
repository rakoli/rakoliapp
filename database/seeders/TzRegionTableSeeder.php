<?php
/**************************************************************************
 * Copyright (C) don, Inc - All Rights Reserved
 *
 * @file        TzRegionTableSeeder.php
 * @author      don
 * @site        <donphelix.com>
 * @date        09/08/2023
 */


namespace Database\Seeders;

use App\Models\Region;
use App\Models\Towns;
use App\Utils\Helpers;
use Illuminate\Database\Seeder;

class TzRegionTableSeeder extends Seeder
{
    public function run(): void
    {
        $regions = [
            'Arusha', 'Dar es Salaam', 'Dodoma', 'Geita', 'Iringa', 'Kagera', 'Katavi', 'Kigoma',
            'Kilimanjaro', 'Lindi', 'Manyara', 'Mara', 'Mbeya', 'Morogoro', 'Mtwara', 'Mwanza',
            'Njombe', 'Pemba Kaskazini', 'Pemba Kusini', 'Pwani', 'Rukwa', 'Ruvuma', 'Shinyanga',
            'Simiyu', 'Singida', 'Songwe', 'Tabora', 'Tanga', 'Unguja Kaskazini',
            'Unguja Mjini Magharibi', 'Unguja Kusini'
        ];
        foreach ($regions as $regionName) {
            $region = Region::create([
                'country_code' => 'TZ',
                'name' => $regionName,
                'code' => "TZ_".cleanText($regionName)
            ]);

            $districtsData[] = include_once __DIR__ . '/seeds/tzlocations.php';
//            print_r($districtsData[0]);
            $districts = $this->getDistrictsByRegion($regionName, $districtsData[0]);

            foreach ($districts as $districtName) {
                Towns::create([
                    'country_code'=>'TZ',
                    'region_code' => $region->code,
                    'name' => $districtName,
                    'code' => $region->code."_".cleanText($districtName)
                ]);
            }
        }
    }

    private function getDistrictsByRegion(string $region, array $districtsData): array
    {
        {
            $filteredDistricts = array_filter($districtsData, function ($districtData) use ($region) {
                return $districtData['region'] === $region;
            });

            return array_column($filteredDistricts, 'district');
        }
    }
}

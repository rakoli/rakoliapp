<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Country;
use App\Models\Towns;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class WardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //TANZANIA WARDS
        $jsonPath = __DIR__.'/seeds/tzlocations_ward.json';
        if (!file_exists($jsonPath)) {
            echo "Error: JSON file not found at path: $jsonPath";
            exit;
        }
        $rawWardsData = json_decode(file_get_contents($jsonPath), true);
        $processedWardsData = [];
        foreach ($rawWardsData as $rawWardsDatum) {
            $processedWardsData[] = [
                'district' => $rawWardsDatum['properties']['District'],
                'ward' => $rawWardsDatum['properties']['Ward'],
            ];
        }
        $jsonWardsData = collect($processedWardsData);
        $towns = Towns::where('country_code','TZ')->get();
        foreach ($towns as $town) {
            $townWards = $jsonWardsData->where('district', $town->name);
            if($townWards->count() == 0){
//                echo "TZ $town->name has no ward\n";
            }
            foreach ($townWards as $townWard) {
                Area::create([
                    'code' => $town->code.'_'.cleanText($townWard['ward']),
                    'country_code' => 'TZ',
                    'region_code' => $town->region_code,
                    'town_code' => $town->code,
                    'name' => $townWard['ward'],
                ]);
            }

        }

    }
}

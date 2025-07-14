<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageAvailableFeatures;
use App\Models\PackageFeature;
use App\Models\PackageName;
use App\Models\Shift;
use App\Models\User;
use App\Utils\Enums\FeatureAccessEnum;
use Illuminate\Database\Seeder;

class PackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $growthPackage = PackageName::create([
            'name' => 'growth'
        ]);
        $prosperityPackage = PackageName::create([
            'name' => 'prosperity'
        ]);
        $elitePackage = PackageName::create([
            'name' => 'elite'
        ]);
        $trialPackage = PackageName::create([
            'name' => 'trial'
        ]);

        if(config('app.env') != 'production') {
            $testPackage = PackageName::create([
                'name' => 'test'
            ]);
        }

        $tz_plans = [
            [
                'country_code' => "TZ",
                'name' => $growthPackage->name,
                'code' => generateCode($growthPackage->name,"tz"),
                'price' => 60000,
                'price_currency' => 'tzs',
                'price_commission' => 1800,//3%
                'package_interval_days' => 365,
                'description' => "Start growing agents business"
            ],
            [
                'country_code' => "TZ",
                'name' => $prosperityPackage->name,
                'code' => generateCode($prosperityPackage->name,"tz"),
                'price' => 100000,
                'price_currency' => 'tzs',
                'price_commission' => 3000,//3%
                'package_interval_days' => 365,
                'description' => "Expand and prosper agency business"
            ],
            [
                'country_code' => "TZ",
                'name' => $elitePackage->name,
                'code' => generateCode($elitePackage->name,"tz"),
                'price' => 150000,
                'price_currency' => 'tzs',
                'price_commission' => env('GRACE_PERIOD', false) ? 500 : 4500,//3%
                'package_interval_days' => 365,
                'description' => "Full control of agency business"
            ],
            [
                'country_code' => "TZ",
                'name' => $trialPackage->name,
                'code' => generateCode($trialPackage->name,"tz"),
                'price' => 0,
                'price_currency' => 'tzs',
                'price_commission' => 0,//0%
                'package_interval_days' => 30,
                'description' => "Full control of agency business"
            ],
        ];


        if(config('app.env') != 'production') {
            $tz_plans[] = [
                'country_code' => "TZ",
                'name' => $testPackage->name,
                'code' => generateCode($testPackage->name,"tz"),
                'price' => 5000,
                'price_currency' => 'tzs',
                'price_commission' => 50,//3%
                'package_interval_days' => 365,
                'description' => "Full control of agency business"
            ];
        }


        $ke_plans = [
            [
                'country_code' => "KE",
                'name' => $growthPackage->name,
                'code' => generateCode($growthPackage->name,"ke"),
                'price' => 3000,
                'price_currency' => 'kes',
                'price_commission' => 90,//3%
                'package_interval_days' => 365,
                'description' => "Start growing agents business"
            ],
            [
                'country_code' => "KE",
                'name' => $prosperityPackage->name,
                'code' => generateCode($prosperityPackage->name,"ke"),
                'price' => 5000,
                'price_currency' => 'kes',
                'price_commission' => 150,//3%
                'package_interval_days' => 365,
                'description' => "Expand and prosper agency business"
            ],
            [
                'country_code' => "KE",
                'name' => $elitePackage->name,
                'code' => generateCode($elitePackage->name,"ke"),
                'price' => 7500,
                'price_currency' => 'kes',
                'price_commission' => 225,//3%
                'package_interval_days' => 365,
                'description' => "Full control of agency business"
            ],
        ];


        foreach($tz_plans as $tz_plan) {
            Package::create($tz_plan);
        }

        foreach($ke_plans as $ke_plan) {
            Package::create($ke_plan);
        }

        //Available Features
        $branchFeature = PackageAvailableFeatures::create([
            'code' => generateCode('branches'),
            'name' => 'branches',
        ]);
        $tillFeature = PackageAvailableFeatures::create([
            'code' => generateCode('tills'),
            'name' => 'tills',
        ]);
        $shiftFeature = PackageAvailableFeatures::create([
            'code' => generateCode('shift tracking'),
            'name' => 'shift tracking',
        ]);
        $shortFeature = PackageAvailableFeatures::create([
            'code' => generateCode('shorts management'),
            'name' => 'short management',
        ]);
        $loansFeature = PackageAvailableFeatures::create([
            'code' => generateCode('loan management'),
            'name' => 'loan management',
        ]);
        $exchangeFeature = PackageAvailableFeatures::create([
            'code' => generateCode('float exchange'),
            'name' => 'float exchange',
        ]);
        $exchangeAdsFeature = PackageAvailableFeatures::create([
            'code' => generateCode('post exchange ads'),
            'name' => 'post exchange ads',
        ]);
        $vasFeature = PackageAvailableFeatures::create([
            'code' => generateCode('VAS opportunity'),
            'name' => 'VAS opportunity',
        ]);


        //Each package feature
        foreach (Package::get() as $package) {

            if($package->name == $growthPackage->name){
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $exchangeFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $vasFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $branchFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'feature_value' => 1,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $tillFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'feature_value' => 3,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $shiftFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'feature_value' => 1,
                    'available' => 0
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $shortFeature->code,
                    'access' => FeatureAccessEnum::NOTAVAILABLE->value,
                    'available' => 0
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $loansFeature->code,
                    'access' => FeatureAccessEnum::NOTAVAILABLE->value,
                    'available' => 0
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $exchangeAdsFeature->code,
                    'access' => FeatureAccessEnum::NOTAVAILABLE->value,
                    'available' => 0
                ]);
            }

            if($package->name == $prosperityPackage->name){
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $exchangeFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $vasFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $branchFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'feature_value' => 3,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $tillFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'feature_value' => 10,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $shiftFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'feature_value' => 2,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $shortFeature->code,
                    'access' => FeatureAccessEnum::NOTAVAILABLE->value,
                    'available' => 0
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $loansFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'feature_value' => 10,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $exchangeAdsFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'feature_value' => 2,
                    'available' => 1
                ]);
            }

            if($package->name == $elitePackage->name){
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $exchangeFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $vasFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $branchFeature->code,
                    'access' => FeatureAccessEnum::UNLIMTED->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $tillFeature->code,
                    'access' => FeatureAccessEnum::UNLIMTED->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $shiftFeature->code,
                    'access' => FeatureAccessEnum::UNLIMTED->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $shortFeature->code,
                    'access' => FeatureAccessEnum::UNLIMTED->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $loansFeature->code,
                    'access' => FeatureAccessEnum::UNLIMTED->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $exchangeAdsFeature->code,
                    'access' => FeatureAccessEnum::UNLIMTED->value,
                    'available' => 1
                ]);
            }

            if(config('app.env') != 'production' && $package->name == $testPackage->name){
                //ELITE FEATURES TAKEN
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $exchangeFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $vasFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $branchFeature->code,
                    'access' => FeatureAccessEnum::UNLIMTED->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $tillFeature->code,
                    'access' => FeatureAccessEnum::UNLIMTED->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $shiftFeature->code,
                    'access' => FeatureAccessEnum::UNLIMTED->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $shortFeature->code,
                    'access' => FeatureAccessEnum::UNLIMTED->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $loansFeature->code,
                    'access' => FeatureAccessEnum::UNLIMTED->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $exchangeAdsFeature->code,
                    'access' => FeatureAccessEnum::UNLIMTED->value,
                    'available' => 1
                ]);
            }

            if($package->name == $trialPackage->name){
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $exchangeFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $vasFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $branchFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'feature_value' => 1,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $tillFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'feature_value' => 1,
                    'available' => 1
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $shiftFeature->code,
                    'access' => FeatureAccessEnum::AVAILABLE->value,
                    'feature_value' => 1,
                    'available' => 0
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $shortFeature->code,
                    'access' => FeatureAccessEnum::NOTAVAILABLE->value,
                    'available' => 0
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $loansFeature->code,
                    'access' => FeatureAccessEnum::NOTAVAILABLE->value,
                    'available' => 0
                ]);
                PackageFeature::create([
                    'package_code' => $package->code,
                    'feature_code' => $exchangeAdsFeature->code,
                    'access' => FeatureAccessEnum::NOTAVAILABLE->value,
                    'available' => 0
                ]);
            }

        }


    }
}

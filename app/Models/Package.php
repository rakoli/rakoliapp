<?php

namespace App\Models;

use App\Utils\Enums\FeatureAccessEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function country() : BelongsTo
    {
        return  $this->belongsTo(Country::class,'country_code','code');
    }

    public function features() : HasMany
    {
        return  $this->hasMany(PackageFeature::class,'package_code','code');
    }

    public function featuresAvailable() : HasMany
    {
        return  $this->hasMany(PackageFeature::class,'package_code','code')->where('available', 1);;
    }

    public function businesses() : HasMany
    {
        return $this->hasMany(Business::class, 'package_code', 'code');
    }

    public function addPackage()
    {
        $trialPackage = PackageName::create([
            'name' => 'trial'
        ]);

        Package::create([
            'country_code' => "TZ",
            'name' => $trialPackage->name,
            'code' => generateCode($trialPackage->name,"tz"),
            'price' => 0,
            'price_currency' => 'tzs',
            'price_commission' => 0,//0%
            'package_interval_days' => 14,
            'description' => "Trial of our agency business"
        ]);

        Package::create([
            'country_code' => "KE",
            'name' => $trialPackage->name,
            'code' => generateCode($trialPackage->name,"ke"),
            'price' => 0,
            'price_currency' => 'kes',
            'price_commission' => 0,//0%
            'package_interval_days' => 14,
            'description' => "Trial of our agency business"
        ]);

        $branchFeature = PackageAvailableFeatures::where('name','branches')->first();
        $tillFeature = PackageAvailableFeatures::where('name','tills')->first();
        $shiftFeature = PackageAvailableFeatures::where('name','shift tracking')->first();
        $shortFeature = PackageAvailableFeatures::where('name','short management')->first();
        $loansFeature = PackageAvailableFeatures::where('name','loan management')->first();
        $exchangeFeature = PackageAvailableFeatures::where('name','float exchange')->first();
        $exchangeAdsFeature = PackageAvailableFeatures::where('name','post exchange ads')->first();
        $vasFeature = PackageAvailableFeatures::where('name','VAS opportunity')->first();

        foreach (Package::get() as $package) {

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

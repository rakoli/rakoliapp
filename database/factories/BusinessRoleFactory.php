<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BusinessRole>
 */
class BusinessRoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $businesses = Business::get(['code','business_name'])->toArray();
        $selectedBusiness = null;
        if(empty($businesses)){
            $selectedBusiness = Business::factory()->create()->toArray();
        }else{
            $selectedBusiness = fake()->randomElement($businesses);
        }


        $locationsModels = Location::where('business_code',$selectedBusiness['code'])->get('code');
        if($locationsModels->isEmpty()){
            $locationsModels = Location::factory()->count(1)->create();
        }
        $locations = $locationsModels->toArray();

        return [
            'business_code' => $selectedBusiness['code'],
            'code' => Str::random(10),
            'name' => fake()->sentence,
        ];
    }
}

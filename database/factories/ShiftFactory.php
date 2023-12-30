<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\FinancialServiceProvider;
use App\Models\Location;
use App\Models\User;
use App\Utils\Enums\BusinessTypeEnum;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shift>
 */
class ShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $businesses = Business::get('code')->toArray();
        $businessCode = null;
        if(isEmpty($businesses)){
            $businessCode = Business::factory()->create()->code;
        }else{
            $businessCode = fake()->randomElement($businesses)['code'];
        }
        $business = Business::where('code',$businessCode)->first();


        $locationsModels = Location::where('business_code',$businessCode)->get('code');
        if($locationsModels->isEmpty()){
            $locationsModels = Location::factory()->count(1)->create();
        }
        $locations = $locationsModels->toArray();


        $users = User::where('business_code',$businessCode)->get()->toArray();
        $userCode = null;
        if(isEmpty($users)){
            $userCode = User::factory()->create(['business_code'=>$businessCode])->code;
        }else{
            $userCode = fake()->randomElement($users)['code'];
        }

        return [
            'business_code' => $businessCode,
            'location_code' => fake()->randomElement($locations)['code'],
            'user_code' => $userCode,
            'no' => fake()->randomElement([1,2,3]),
            'cash_start' => fake()->numberBetween(40000, 100000),
            'cash_end' => fake()->numberBetween(100000, 500000),
            'currency' => fake()->randomElement(['kes','tzs']),
            'status' => fake()->randomElement(ShiftStatusEnum::class),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Country;
use App\Utils\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    public function definition(): array
    {
        $countries = Country::get('code')->toArray();
        $countryCode = null;
        if(isEmpty($countries)){
            $countryCode = Country::factory()->create()->code;
        }else{
            $countryCode = fake()->randomElement($countries)['code'];
        }

        $businesses = Business::get('code')->toArray();
        $businessCode = null;
        if($businesses == null){
            $businessCode = Business::factory()->create()->code;
        }else{
            $businessCode = fake()->randomElement($businesses)['code'];
        }
        $fname = fake()->firstName;
        $lname = fake()->lastName;
        $name = "$fname $lname";

        return [
            'country_code' => $countryCode,
            'fname' => $fname,
            'lname' => $lname,
            'phone' => '255766'.fake()->numerify("######"),
            'email' => fake()->email,
            'code' => generateCode($name),
            'password' => Hash::make('12345678'),
            'type' => UserTypeEnum::AGENT->value,
            'business_code' => $businessCode,
        ];
    }

}

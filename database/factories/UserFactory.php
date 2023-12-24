<?php

namespace Database\Factories;

use App\Models\Business;
use App\Utils\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    public function definition(): array
    {
        $businesses = Business::get('code')->toArray();
        $fname = fake()->firstName;
        $lname = fake()->lastName;
        $name = "$fname $lname";

        return [
            'country_code' => 'TZ',
            'fname' => $fname,
            'lname' => $lname,
            'phone' => '255766'.fake()->numerify("######"),
            'email' => fake()->email,
            'code' => generateCode($name),
            'password' => Hash::make('12345678'),
            'type' => UserTypeEnum::AGENT->value,
            'business_code' => fake()->randomElement($businesses)['code'],
        ];
    }

}

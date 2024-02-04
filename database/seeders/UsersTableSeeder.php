<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\ExchangeBusinessMethod;
use App\Models\FinancialServiceProvider;
use App\Models\Location;
use App\Models\Package;
use App\Models\User;
use App\Utils\Enums\BusinessStatusEnum;
use App\Utils\Enums\UserTypeEnum;
use App\Utils\Enums\WalkThroughStepEnums;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        //AGENT BUSINESS
        $name = "Vertice Agents Ltd";
        $agentBusiness = Business::addBusiness([
            'country_code' => "TZ",
            'type' => UserTypeEnum::AGENT->value,
            'code'=> generateCode($name),
            'business_name' => $name,
            'tax_id' => $faker->unique()->numerify('###-###-###'),
            'business_regno' => $faker->unique()->numerify('#########'),
            'business_phone_number' => '255739466080',
            'business_email' => "agent@rakoli.com",
            'business_location' => $faker->address,
            'package_code' => Package::where('name','prosperity')->first()->code,
            'package_expiry_at' => now()->addDays(random_int(5,30)),
            'status' => BusinessStatusEnum::ACTIVE->value
        ]);

        Location::create([
            'business_code' => $agentBusiness->code,
            'code' => Str::random(10) ,
            'name' => 'Vertice Branch',
            'balance' => fake()->numberBetween(500000, 5000000),
            'balance_currency' => fake()->randomElement(['kes','tzs']),
        ]);

        //VAS BUSINESS
        $name = "Pulsans Advertisement Ltd";
        $vasBusiness = Business::addBusiness([
            'country_code' => "TZ",
            'type' => UserTypeEnum::VAS->value,
            'code'=> generateCode($name),
            'business_name' => $name,
            'tax_id' => $faker->unique()->numerify('###-###-###'),
            'business_regno' => $faker->unique()->numerify('#########'),
            'business_phone_number' => '255739466080',
            'business_email' => "vas@rakoli.com",
            'business_location' => $faker->address,
            'package_code' => null,
            'package_expiry_at' => null,
            'status' => BusinessStatusEnum::ACTIVE->value
        ]);

        //ADMIN BUSINESS
        $name = "RAKOLI SYSTEMS";
        $adminBusiness = Business::addBusiness([
            'country_code' => "TZ",
            'type' => UserTypeEnum::ADMIN->value,
            'code'=> generateCode($name),
            'business_name' => $name,
            'status' => BusinessStatusEnum::ACTIVE->value
        ]);

        // Specific users provided in the data
        $users = [
            [
                'country_code' => 'TZ',
                'fname' => 'Elin',
                'lname' => 'Erick',
                'phone' => '255739466080',
                'email' => 'agent@rakoli.com',
                'code' => generateCode('Elin Erick',),
                'password' => Hash::make('12345678'),
                'type' => UserTypeEnum::AGENT->value,
                'business_code' => $agentBusiness->code,
                'registration_step' => 0,
            ],
            [
                'country_code' => 'TZ',
                'fname' => 'Felix',
                'lname' => 'Mihayo',
                'phone' => '255753464603',
                'email' => 'vas@rakoli.com',
                'code' => generateCode('Felix Mihayo'),
                'password' => Hash::make('12345678'),
                'type' => UserTypeEnum::VAS->value,
                'business_code' => $vasBusiness->code,
                'registration_step' => 0,
            ],
            [
                'country_code' => 'TZ',
                'fname' => 'Erick',
                'lname' => 'Mabusi',
                'phone' => '255763466080',
                'email' => 'admin@rakoli.com',
                'code' => generateCode('Erick Mabusi'),
                'password' => Hash::make('12345678'),
                'type' => UserTypeEnum::ADMIN->value,
                'business_code' => $adminBusiness->code,
                'registration_step' => 0,
            ],
        ];

        foreach($users as $user) {

            User::create($user);

        }

    }
}

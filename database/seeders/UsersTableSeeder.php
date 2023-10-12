<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\User;
use App\Utils\Enums\BusinessStatusEnum;
use App\Utils\Enums\UserTypeEnum;
use App\Utils\Enums\WalkThroughStepEnums;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

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
        $agentBusiness = Business::create([
            'country_code' => "TZ",
            'type' => UserTypeEnum::AGENT,
//                    'walkthrough_step' => WalkThroughStepEnums::BUSINESS->value,
            'code'=> generateCode($name),
            'business_name' => $name,
            'tax_id' => $faker->unique()->numerify('###-###-###'),
            'business_regno' => $faker->unique()->numerify('#########'),
            'business_phone_number' => '255739466080',
            'business_email' => "agent@rakoli.com",
            'business_location' => $faker->address,
            'package_code' => null,
            'subscription_code' => null,
            'expiry_at' => null,
            'status' => BusinessStatusEnum::ACTIVE
        ]);

        //VAS BUSINESS
        $name = "Pulsans Advertisement Ltd";
        $vasBusiness = Business::create([
            'country_code' => "TZ",
            'type' => UserTypeEnum::VAS,
//                    'walkthrough_step' => WalkThroughStepEnums::BUSINESS->value,
            'code'=> generateCode($name),
            'business_name' => $name,
            'tax_id' => $faker->unique()->numerify('###-###-###'),
            'business_regno' => $faker->unique()->numerify('#########'),
            'business_phone_number' => '255739466080',
            'business_email' => "vas@rakoli.com",
            'business_location' => $faker->address,
            'package_code' => null,
            'subscription_code' => null,
            'expiry_at' => null,
            'status' => BusinessStatusEnum::ACTIVE
        ]);

        // Specific users provided in the data
        $users = [
            [
                'name' => 'Elin Erick',
                'phone' => '+255739466080',
                'email' => 'agent@rakoli.com',
                'code' => generateCode('Elin Erick',),
                'password' => Hash::make('12345678'),
                'type' => UserTypeEnum::AGENT,
                'business_code' => $agentBusiness->code,
            ],
            [
                'name' => 'Felix Mihayo',
                'phone' => '+255753464603',
                'email' => 'vas@rakoli.com',
                'code' => generateCode('Felix Mihayo'),
                'password' => Hash::make('12345678'),
                'type' => UserTypeEnum::VAS,
                'business_code' => $vasBusiness->code,
            ],
            [
                'name' => 'Erick Mabusi',
                'phone' => '+255763466080',
                'email' => 'admin@rakoli.com',
                'code' => generateCode('Erick Mabusi'),
                'password' => Hash::make('12345678'),
                'type' => UserTypeEnum::ADMIN,
            ],
        ];

        foreach($users as $user) {

            User::create($user);

        }

    }
}

<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Package;
use App\Models\User;
use App\Utils\Enums\BusinessStatusEnum;
use App\Utils\Enums\UserTypeEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SampleReferralBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $businesses = Business::get();

        foreach ($businesses as $business) {

            $activeOne = Business::addBusiness([
                'country_code' => "TZ",
                'type' => UserTypeEnum::AGENT->value,
                'code'=> generateCode(Str::random(8)),
                'business_name' => fake()->company,
                'package_code' => Package::where(['name'=>'prosperity','country_code'=>'TZ'])->first()->code,
                'package_expiry_at' => now()->addDays(random_int(30,300)),
                'status' => BusinessStatusEnum::ACTIVE->value,
                'referral_business_code' => $business->code
            ]);
            User::create([
                'country_code' => $business->country_code,
                'fname' => fake()->firstName,
                'lname' => fake()->lastName,
                'phone' => '255719'.fake()->randomNumber(6,true),
                'email' => fake()->email,
                'code' => generateCode(Str::random(8)),
                'password' => Hash::make('12345678'),
                'type' => UserTypeEnum::AGENT->value,
                'business_code' => $activeOne->code,
                'registration_step' => 0,
                'referral_business_code' => $business->code,
            ]);

            $activeTwo = Business::addBusiness([
                'country_code' => "TZ",
                'type' => UserTypeEnum::AGENT->value,
                'code'=> generateCode(Str::random(8)),
                'business_name' => fake()->company,
                'package_code' => Package::where(['name'=>'elite','country_code'=>'TZ'])->first()->code,
                'package_expiry_at' => now()->addDays(random_int(30,300)),
                'status' => BusinessStatusEnum::ACTIVE->value,
                'referral_business_code' => $business->code
            ]);
            User::create([
                'country_code' => $business->country_code,
                'fname' => fake()->firstName,
                'lname' => fake()->lastName,
                'phone' => '255719'.fake()->randomNumber(6,true),
                'email' => fake()->email,
                'code' => generateCode(Str::random(8)),
                'password' => Hash::make('12345678'),
                'type' => UserTypeEnum::AGENT->value,
                'business_code' => $activeTwo->code,
                'registration_step' => 0,
                'referral_business_code' => $business->code,
            ]);


            //InActive User
            $inactive = Business::addBusiness([
                'country_code' => "TZ",
                'type' => UserTypeEnum::AGENT->value,
                'code'=> generateCode(Str::random(10)),
                'business_name' => fake()->company,
                'status' => BusinessStatusEnum::ACTIVE->value,
                'referral_business_code' => $business->code
            ]);
            User::create([
                'country_code' => $business->country_code,
                'fname' => fake()->firstName,
                'lname' => 'Inactive',
                'phone' => '255719'.fake()->randomNumber(6,true),
                'email' => fake()->email,
                'code' => generateCode(Str::random(8)),
                'password' => Hash::make('12345678'),
                'type' => UserTypeEnum::AGENT->value,
                'business_code' => $inactive->code,
                'registration_step' => 0,
                'referral_business_code' => $business->code,
            ]);
        };
    }
}

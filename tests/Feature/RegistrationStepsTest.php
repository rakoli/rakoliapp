<?php

namespace Tests\Feature;

use App\Models\Business;
use App\Models\Country;
use App\Models\Package;
use App\Models\User;
use App\Utils\Enums\UserTypeEnum;
use App\Utils\VerifyOTP;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationStepsTest extends TestCase
{
    /** @test */
    public function only_agent_users_with_pending_registration_can_access_agent_registration_steps()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>1]);
        $this->actingAs($user);
        $response = $this->get(route('registration.agent'));
        $response->assertOk();
        $response->assertSee('Agent Registration');

        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);
        $this->actingAs($user);
        $response = $this->get(route('registration.agent'));
        $response->assertRedirect(route('home'));
    }

    /** @test */
    public function only_vas_users_with_pending_registration_can_access_vas_registration_steps()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::VAS->value, 'registration_step'=>1]);
        $this->actingAs($user);
        $response = $this->get(route('registration.agent'));
        $response->assertOk();
        $response->assertSee('Agent Registration');

        $user = User::factory()->create(['type'=>UserTypeEnum::VAS->value, 'registration_step'=>0]);
        $this->actingAs($user);
        $response = $this->get(route('registration.agent'));
        $response->assertRedirect(route('home'));
    }

    /** @test */
    public function user_can_request_email_code_successfully()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>1]);//Not dependent on user type
        $this->actingAs($user);

        $response = $this->get(route('request.email.code'));

        $user = User::where('id',$user->id)->first();

        $response->assertJson([
            'status' => 200,
            'message' => 'successful',
        ]);
        $this->assertNotNull($user->email_otp);
    }

    /** @test */
    public function user_can_confirm_email_code_successfully()
    {
        $otp = '123456';
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>1,'email_otp'=>$otp]);//Not dependent on user type
        $this->actingAs($user);

        $response = $this->get(route('verify.email.code',['email_code'=>$otp]));

        $response->assertJson([
            'status' => 200,
            'message' => 'valid',
        ]);

        $this->assertNotNull($user->email_verified_at);
        $this->assertNull($user->email_otp);

    }

    /** @test */
    public function user_email_code_request_can_be_locked__and_doesnt_double_send()
    {
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'registration_step'=>1,
            'email_otp_count'=>(VerifyOTP::$shouldLockCount+1),
        ]);
        $this->actingAs($user);

        //Locked when user has already sent request above limit
        $response = $this->get(route('request.email.code'));
        $response->assertJson([
            'status' => 201,
            'message' => 'Account locked! Reached trial limit',
        ]);

        //Does not send during waiting time
        $user->email_otp = '123456';
        $user->email_otp_count = 0;
        $user->email_otp_time = now();
        $user->save();
        $response = $this->get(route('request.email.code'));
        $this->assertStringContainsString('Email already sent',$response->json('message'));

        //Does not send to already verified email
        $user->email_verified_at = now();
        $user->save();
        $response = $this->get(route('request.email.code'));
        $response->assertJson([
            'status' => 200,
            'message' => 'Email already verified',
        ]);
    }

    /** @test */
    public function user_can_request_phone_code_successfully()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>1]);//Not dependent on user type
        $this->actingAs($user);

        $response = $this->get(route('request.phone.code'));

        $user = User::where('id',$user->id)->first();

        $response->assertJson([
            'status' => 200,
            'message' => 'successful',
        ]);
        $this->assertNotNull($user->phone_otp);
    }

    /** @test */
    public function user_can_confirm_phone_code_successfully()
    {
        $otp = '123456';
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>1,'phone_otp'=>$otp]);//Not dependent on user type
        $this->actingAs($user);

        $response = $this->get(route('verify.phone.code',['phone_code'=>$otp]));

        $response->assertJson([
            'status' => 200,
            'message' => 'valid',
        ]);

        $this->assertNotNull($user->phone_verified_at);
        $this->assertNull($user->phone_otp);

    }


    /** @test */
    public function user_phone_code_request_can_be_locked__and_doesnt_double_send()
    {
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'registration_step'=>1,
            'phone_otp_count'=>(VerifyOTP::$shouldLockCount+1),
        ]);
        $this->actingAs($user);

        //Locked when user has already sent request above limit
        $response = $this->get(route('request.phone.code'));
        $response->assertJson([
            'status' => 201,
            'message' => 'Account locked! Reached trial limit',
        ]);

        //Does not send during waiting time
        $user->phone_otp = '123456';
        $user->phone_otp_count = 0;
        $user->phone_otp_time = now();
        $user->save();
        $response = $this->get(route('request.phone.code'));
        $this->assertStringContainsString('SMS already sent',$response->json('message'));

        //Does not send to already verified phone
        $user->phone_verified_at = now();
        $user->save();
        $response = $this->get(route('request.phone.code'));
        $response->assertJson([
            'status' => 200,
            'message' => 'Phone already verified',
        ]);
    }

    /** @test */
    public function user_can_edit_contact_information_on_registration_step_process()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>1]);//Not dependent on user type
        $this->actingAs($user);

        $newEmail = fake()->email;
        $newPhone = '255766'.fake()->numerify("######");
        $response = $this->post(route('edit.contact.information',['email'=> $newEmail,'phone'=>$newPhone]));

        $this->assertDatabaseHas('users', [
            'code' => $user->code,
            'email' => $newEmail,
            'phone' => $newPhone,
        ]);
    }

    /** @test */
    public function user_edit_contact_does_not_update_already_verified_data()
    {
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'registration_step'=>1,
            'email_verified_at'=>now(),
            'phone_verified_at'=>now(),
        ]);
        $this->actingAs($user);

        $newEmail = fake()->email;
        $newPhone = '255766'.fake()->numerify("######");

        $response = $this->post(route('edit.contact.information',['email'=> $newEmail,'phone'=>$newPhone]));

        $this->assertDatabaseHas('users', [
            'code' => $user->code,
            'email' => $user->email,
            'phone' => $user->phone,
        ]);
    }

    /** @test */
    public function user_can_move_from_step_01_to_02_after_verifying_contact_info()
    {
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'registration_step'=>1,
            'email_verified_at'=>now(),
            'phone_verified_at'=>now(),
        ]);
        $this->actingAs($user);
        $currentStep = $user->registration_step;

        $response = $this->get(route('registration.step.confirmation',['next_step'=> 2]));

        $response->assertJson([
            'status' => 200,
            'message' => 'continue',
        ]);
        $this->assertEquals(($currentStep+1),$user->registration_step);
    }

    /** @test */
    public function user_registration_can_submit_business_details()
    {
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'registration_step'=>1,
            'business_code'=>null
        ]);
        $this->actingAs($user);
        $currentStep = $user->registration_step;

        $business = Business::factory()->make();

        $response = $this->get(route('update.business.details', [
            'business_name'=> $business->business_name,
            'reg_id'=>$business->reg_id,
            'tax_id'=>$business->tax_id,
            'reg_date'=>$business->reg_date
        ]));

        $this->assertDatabaseHas('users',[
            'code' => $user->code,
            'business_code' => $response['business']['code'],
        ]);
    }

    /** @test */
    public function user_registration_can_successfully_submit_business_details_using_business_name_only()
    {
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'registration_step'=>1,
            'business_code'=>null
        ]);
        $this->actingAs($user);
        $currentStep = $user->registration_step;

        $business = Business::factory()->make();

        $response = $this->get(route('update.business.details', [
            'business_name'=> $business->business_name,
        ]));

        $this->assertDatabaseHas('users',[
            'code' => $user->code,
            'business_code' => $response['business']['code'],
        ]);
    }

    /** @test */
    public function user_can_move_from_step_02_to_03_after_entering_business_details()
    {
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'registration_step'=>2,
            'business_code'=> Business::factory()->create()->code
        ]);//Not dependent on user type
        $this->actingAs($user);
        $currentStep = $user->registration_step;

        $response = $this->get(route('registration.step.confirmation',['next_step'=> 3]));

        $response->assertJson([
            'status' => 200,
            'message' => 'continue',
        ]);
        $this->assertEquals(($currentStep+1),$user->registration_step);
    }

    /** @test */
    public function user_can_see_all_available_packages_on_registration_step()
    {
        $business = Business::factory()->create();//Business with active package (package is required to move to next step)
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'registration_step'=>3,
            'business_code'=> $business->code,
            'country_code'=>$business->country_code
        ]);
        $this->actingAs($user);
        $packages = Package::factory()->count(3)->create(['country_code'=>$business->country_code]);

        $response = $this->get(route('registration.agent'));
        $response->assertStatus(200);
        foreach ($packages as $package) {
            $response->assertSee(strtoupper($package->name));
        }
    }

    /** @test */
    public function user_can_move_from_step_03_to_04_after_subscribing_to_a_package()
    {
        $business = Business::factory()->create();//Business with active package (package is required to move to next step)
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'registration_step'=>3,
            'business_code'=> $business->code
        ]);
        $this->actingAs($user);
        $currentStep = $user->registration_step;

        $response = $this->get(route('registration.step.confirmation',['next_step'=> 4]));

        $response->assertJson([
            'status' => 200,
            'message' => 'continue',
        ]);
        $this->assertEquals(($currentStep+1),$user->registration_step);
    }

    /** @test */
    public function user_can_auto_move_from_step_04_to_05_to_complete_registration_process()
    {
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
            'registration_step'=>4
        ]);
        $this->actingAs($user);
        $currentStep = $user->registration_step;

        $response = $this->get(route('registration.step.confirmation',['next_step'=> 5]));

        $response->assertJson([
            'status' => 200,
            'message' => 'Complete',
        ]);
        $this->assertEquals(0,$user->registration_step);
    }

}

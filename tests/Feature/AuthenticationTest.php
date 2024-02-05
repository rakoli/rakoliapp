<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\User;
use App\Utils\Enums\UserTypeEnum;
use Database\Seeders\CountrySeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use WithFaker;

    protected $seeder = CountrySeeder::class;

    /** @test */
    public function guests_are_redirected_to_login_page()
    {
        // Arrange
        $response = $this->get('/');

        // Assert
        $response->assertRedirect('/login');
    }

    /** @test */
    public function guest_user_can_access_login_page()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('Login');
    }

    /** @test */
    public function user_can_login_with_correct_credentials()
    {
        // Arrange
        $password = $this->faker->password;
        $user = User::factory()->create([
            'password' => Hash::make($password),
        ]);

        // Act
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password,
        ]);

        // Assert
        $response->assertContent('1');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_cannot_login_with_incorrect_credentials()
    {
        // Arrange
        $user = User::factory()->create([
            'password' => Hash::make('incorrect_password'),
        ]);

        // Act
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => '12345678',
        ]);

        // Assert
        $response->assertContent('0');
        $this->assertGuest();
    }

    /** @test */
    public function guest_user_can_access_password_reset_page()
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
        $response->assertSee('Email Reset Password');
    }

    /** @test */
    public function guest_user_can_access_agent_register_page()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertSee('Agent Registration');
    }

    /** @test */
    public function guest_user_can_submit_agent_registration_form_without_errors()
    {
        //Added Country to get dialing code
        $countries = Country::get('dialing_code')->toArray();
        $countryDialCode = null;
        if (empty($countries)) {
            $countryDialCode = Country::factory()->create()->dialing_code;
        } else {
            $countryDialCode = fake()->randomElement($countries)['dialing_code'];
        }

        $user = User::factory()->make(); // Create a fake user for form submission

        $response = $this->post(route('register'), [
            'country_dial_code' => $countryDialCode,
            'fname' => $user->fname,
            'lname' => $user->lname,
            'phone' => $user->phone,
            'email' => $user->email,
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $response->assertRedirect(route('home')); // Replace with the actual home route
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'type' => UserTypeEnum::AGENT->value,
        ]);
        $loginInUser = User::where('email', $user->email)->first();
        $this->assertAuthenticatedAs($loginInUser);
    }

    /** @test */
    public function guest_user_can_access_vas_register_page()
    {
        $response = $this->get(route('register.vas'));

        $response->assertStatus(200);
        $response->assertSee('VAS Provider Registration');
    }

    /** @test */
    public function guest_user_can_submit_vas_registration_form_without_errors()
    {
        //Added Country to get dialing code
        $countries = Country::get('dialing_code')->toArray();
        $countryDialCode = null;
        if (empty($countries)) {
            $countryDialCode = Country::factory()->create()->dialing_code;
        } else {
            $countryDialCode = fake()->randomElement($countries)['dialing_code'];
        }

        $user = User::factory()->make(); // Create a fake user for form submission

        $response = $this->post(route('register.vas.submit'), [
            'country_dial_code' => $countryDialCode,
            'fname' => $user->fname,
            'lname' => $user->lname,
            'phone' => $user->phone,
            'email' => $user->email,
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $response->assertRedirect(route('home')); // Replace with the actual home route
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'type' => UserTypeEnum::VAS->value,
        ]);
        $loginInUser = User::where('email', $user->email)->first();
        $this->assertAuthenticatedAs($loginInUser);
    }

    /** @test */
    public function logged_agent_user_with_pending_registration_is_redirected_to_registration_steps()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 1]);

        $this->actingAs($user);

        $response = $this->get(route('home'));

        $response->assertRedirect(route('registration.agent'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function logged_agent_user_with_complete_registration_is_not_redirected_to_registration_steps()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $this->actingAs($user);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function logged_vas_user_with_pending_registration_is_redirected_to_registration_steps()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::VAS->value, 'registration_step' => 1]);

        $this->actingAs($user);

        $response = $this->get(route('home'));

        $response->assertRedirect(route('registration.vas'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function logged_vas_user_with_complete_registration_is_not_redirected_to_registration_steps()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::VAS->value, 'registration_step' => 0]);

        $this->actingAs($user);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function agent_user_can_only_access_its_own_dashboard_and_routes()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $this->actingAs($user);

        $response = $this->get(route('agent.dashboard'));
        $response->assertOk();
        $response->assertSee('Dashboard');

        $response = $this->get(route('vas.dashboard'));
        $response->assertRedirect(route('home'));

        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('home'));

    }

    /** @test */
    public function vas_user_can_only_access_its_own_dashboard_and_routes()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::VAS->value, 'registration_step' => 0]);

        $this->actingAs($user);

        $response = $this->get(route('agent.dashboard'));
        $response->assertRedirect(route('home'));

        $response = $this->get(route('vas.dashboard'));
        $response->assertOk();
        $response->assertSee('Dashboard');

        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('home'));

    }

    /** @test */
    public function admin_user_can_only_access_its_own_dashboard_and_routes()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::ADMIN->value, 'registration_step' => 0]);

        $this->actingAs($user);

        $response = $this->get(route('agent.dashboard'));
        $response->assertRedirect(route('home'));

        $response = $this->get(route('vas.dashboard'));
        $response->assertRedirect(route('home'));

        $response = $this->get(route('admin.dashboard'));
        $response->assertOk();
        $response->assertSee('Dashboard');

    }
}

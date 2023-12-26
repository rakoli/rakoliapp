<?php

namespace Tests\Unit;

use App\Http\Middleware\LanguageSwitchMiddleware;
use App\Http\Middleware\OnlyAdminMiddleware;
use App\Http\Middleware\OnlyAgentMiddleware;
use App\Http\Middleware\OnlyVASMiddleware;
use App\Http\Middleware\ShouldCompleteRegistrationMiddleware;
use App\Models\User;
use App\Utils\Enums\UserTypeEnum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{

    /** @test */
    public function non_admins_users_are_redirected_using_onlyadminmiddleware()
    {
        $nonAdminUser = User::factory()->create(['type'=>UserTypeEnum::AGENT->value]);

        $requestNonAdmin = Request::create(route('admin.dashboard'), 'GET');
        $requestNonAdmin->setUserResolver(function () use ($nonAdminUser) {
            return $nonAdminUser;
        });
        $middleware = new OnlyAdminMiddleware();
        $response = $middleware->handle($requestNonAdmin, function () {return new Response();});
        $this->assertTrue($response->isRedirect(route('home')));
        $this->assertEquals($response->getStatusCode(), 302);

    }

    /** @test */
    public function admins_are_not_redirected_on_onlyadminmiddleware()
    {
        $adminUser = User::factory()->create(['type'=>UserTypeEnum::ADMIN->value]);

        $requestAdmin = Request::create(route('admin.dashboard'), 'GET');
        $requestAdmin->setUserResolver(function () use ($adminUser) {
            return $adminUser;
        });
        $middleware = new OnlyAdminMiddleware();
        $response = $middleware->handle($requestAdmin, function () { return new Response();});
        $this->assertEquals($response->getStatusCode(), 200);

    }

    /** @test */
    public function non_vas_users_are_redirected_using_onlyvasmiddleware()
    {
        $nonVasUser = User::factory()->create(['type'=>UserTypeEnum::AGENT->value]);

        $requestNonVas = Request::create(route('vas.dashboard'), 'GET');
        $requestNonVas->setUserResolver(function () use ($nonVasUser) {
            return $nonVasUser;
        });
        $middleware = new OnlyVASMiddleware();
        $response = $middleware->handle($requestNonVas, function () {return new Response();});
        $this->assertTrue($response->isRedirect(route('home')));
        $this->assertEquals($response->getStatusCode(), 302);
    }

    /** @test */
    public function vas_users_are_not_redirected_on_onlyvasmiddleware()
    {
        $vasUser = User::factory()->create(['type'=>UserTypeEnum::VAS->value]);

        $requestVas = Request::create(route('vas.dashboard'), 'GET');
        $requestVas->setUserResolver(function () use ($vasUser) {
            return $vasUser;
        });
        $middleware = new OnlyVASMiddleware();
        $response = $middleware->handle($requestVas, function () { return new Response();});
        $this->assertEquals($response->getStatusCode(), 200);

    }

    /** @test */
    public function non_agent_users_are_redirected_using_onlyagentmiddleware()
    {
        $nonAgentUser = User::factory()->create(['type'=>UserTypeEnum::VAS->value]);

        $agentRequest = Request::create(route('agent.dashboard'), 'GET');
        $agentRequest->setUserResolver(function () use ($nonAgentUser) {
            return $nonAgentUser;
        });
        $middleware = new OnlyAgentMiddleware();
        $response = $middleware->handle($agentRequest, function () {return new Response();});
        $this->assertTrue($response->isRedirect(route('home')));
        $this->assertEquals($response->getStatusCode(), 302);
    }

    /** @test */
    public function agent_users_not_redirected_on_onlyagentmiddleware()
    {
        $agentUser = User::factory()->create(['type'=>UserTypeEnum::AGENT->value]);

        $agentRequest = Request::create(route('agent.dashboard'), 'GET');
        $agentRequest->setUserResolver(function () use ($agentUser) {
            return $agentUser;
        });
        $middleware = new OnlyAgentMiddleware();
        $response = $middleware->handle($agentRequest, function () { return new Response();});
        $this->assertEquals($response->getStatusCode(), 200);

    }

    /** @test */
    public function if_agent_registration_is_not_complete_redirect_to_registration_steps()
    {
        // Arrange
        $middleware = new ShouldCompleteRegistrationMiddleware();

        $user = User::factory()->create(['registration_step'=>1,'type'=>UserTypeEnum::AGENT->value]);

        $request = Request::create('dashboard', 'GET');
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        // Act
        $response = $middleware->handle($request, function () {});

        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertTrue($response->isRedirect(route('registration.agent')));
    }

    /** @test */
    public function if_agent_registration_is_complete_doesnot_redirect_to_registration_steps()
    {
        // Arrange
        $middleware = new ShouldCompleteRegistrationMiddleware();

        $user = User::factory()->create(['registration_step'=>0,'type'=>UserTypeEnum::AGENT->value]);

        $request = Request::create('dashboard', 'GET');
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        // Act
        $response = $middleware->handle($request, function () {
            return new Response('OK');
        });

        // Assert
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('OK', $response->getContent());
    }

    /** @test */
    public function if_vas_registration_is_not_complete_redirect_to_registration_steps()
    {
        // Arrange
        $middleware = new ShouldCompleteRegistrationMiddleware();

        $user = User::factory()->create(['registration_step'=>1,'type'=>UserTypeEnum::VAS->value]);

        $request = Request::create('dashboard', 'GET');
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        // Act
        $response = $middleware->handle($request, function () {});

        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertTrue($response->isRedirect(route('registration.vas')));
    }

    /** @test */
    public function if_vas_registration_is_complete_doesnot_redirect_to_registration_steps()
    {
        // Arrange
        $middleware = new ShouldCompleteRegistrationMiddleware();

        $user = User::factory()->create(['registration_step'=>0,'type'=>UserTypeEnum::VAS->value]);

        $request = Request::create('dashboard', 'GET');
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        // Act
        $response = $middleware->handle($request, function () {
            return new Response('OK');
        });

        // Assert
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('OK', $response->getContent());
    }

}

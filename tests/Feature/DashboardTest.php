<?php

namespace Tests\Feature;

use App\Models\Network;
use App\Models\Shift;
use App\Models\User;
use App\Utils\Enums\UserTypeEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    /** @test */
    public function agent_dashboard_number_of_network_tills()
    {
        $user = User::factory()->create([
            'type'=>UserTypeEnum::AGENT->value,
        ]);
        $this->actingAs($user);

        $noOfTills = 5;
        Network::factory()->count(2)->create();//To validate it is true
        Network::factory()->count($noOfTills)->create(['business_code'=>$user->business_code]);

        $response = $this->get(route('agent.dashboard'));

        $response->assertSee($noOfTills);
    }


}

<?php

namespace Tests\Feature;

use App\Models\Area;
use App\Models\Business;
use App\Models\Location;
use App\Models\Region;
use App\Models\Towns;
use App\Models\User;
use App\Models\VasTask;
use App\Utils\Enums\UserTypeEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OpportunitiesModuleTest extends TestCase
{

    /** @test */
    public function vas_can_view_tasks_page(): void
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::VAS->value]);

        $this->actingAs($user);

        $response = $this->get(route('vas.tasks.index'));
        $response->assertOk();
        $response->assertSee('Tasks');
    }

    /** @test */
    public function vas_can_view_all_business_tasks_list()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::VAS->value]);

        $noOfTasks = 5;
        VasTask::factory()->count($noOfTasks)->create(['vas_business_code'=>$user->business_code]);
        $totalVastasks = VasTask::where('vas_business_code', $user->business_code)->get();
        $totalVastasksCount = $totalVastasks->count();

        $this->actingAs($user);

        $response = $this->getJson(route('vas.tasks.index'),['X-Requested-With'=>'XMLHttpRequest']);
        $responseArray = json_decode($response->content(),'true');

        $allValuesFound = true;
        $firstArray = $totalVastasks->toArray();
        $secondArray = $responseArray['data'];
        $secondArrayIds = [];
        foreach ($secondArray as $item) {
            array_push($secondArrayIds, $item['id']);
        }
        foreach ($firstArray as $firstArrayItem) {
            if (!in_array($firstArrayItem['id'], $secondArrayIds)) {
                $allValuesFound = false;
                break; // No need to continue checking if one value is not found
            }
        }

        $this->assertTrue($allValuesFound);
        $this->assertEquals($totalVastasksCount,$responseArray['recordsTotal']);
    }

    /** @test */
    public function vas_can_view_tasks_create_page(): void
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::VAS->value]);

        $this->actingAs($user);

        $response = $this->get(route('vas.tasks.create'));
        $response->assertOk();
        $response->assertSee('Create Task');
    }

    /** @test */
    public function vas_can_add_a_vas_task()
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type'=>UserTypeEnum::VAS->value, 'business_code'=>$business->code]);

        $this->actingAs($user);

        $region = Region::factory()->create();
        $town = Towns::factory()->create(['region_code'=>$region->code]);
        $area = Area::factory()->create(['region_code'=>$region->code,'town_code'=>$town->code]);
        $taskSample = VasTask::factory()->make();
        $editData = [
            'region_code' => $region->code,
            'town_code' => $town->code,
            'area_code' => $area->code,
            'task_type' => $taskSample->task_type->value,
            'time_start' => now()->addHours(5)->toDateTimeString(),
            'time_end' => now()->addDays(30)->toDateTimeString(),
            'no_of_agents' => $taskSample->no_of_agents,
            'is_public' => $taskSample->is_public,
            'description' => $taskSample->description,
        ];

        $response = $this->post(route('vas.tasks.store',$editData));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('vas.tasks.index'));
        $data = [
            'region_code' => $editData['region_code'],
            'town_code' => $editData['town_code'],
            'area_code' => $editData['area_code'],
            'task_type' => $editData['task_type'],
            'no_of_agents' => $editData['no_of_agents'],
            'is_public' => $editData['is_public'],
            'description' => $editData['description'],
        ];
        $this->assertDatabaseHas('vas_tasks', $data);
    }

    /** @test */
    public function vas_can_add_a_vas_task_without_location_data_and_end_time()
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type'=>UserTypeEnum::VAS->value, 'business_code'=>$business->code]);

        $this->actingAs($user);

        $taskSample = VasTask::factory()->make();
        $editData = [
            'task_type' => $taskSample->task_type->value,
            'time_start' => now()->addHours(5)->toDateTimeString(),
            'no_of_agents' => $taskSample->no_of_agents,
            'is_public' => $taskSample->is_public,
            'description' => $taskSample->description,
        ];

        $response = $this->post(route('vas.tasks.store',$editData));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('vas.tasks.index'));
        $data = [
            'task_type' => $editData['task_type'],
            'no_of_agents' => $editData['no_of_agents'],
            'is_public' => $editData['is_public'],
            'description' => $editData['description'],
        ];
        $this->assertDatabaseHas('vas_tasks', $data);
    }

}

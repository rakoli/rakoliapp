<?php

namespace Tests\Feature;

use App\Models\Area;
use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\ExchangeBusinessMethod;
use App\Models\Location;
use App\Models\Region;
use App\Models\Towns;
use App\Models\User;
use App\Utils\Enums\ExchangeStatusEnum;
use App\Utils\Enums\UserTypeEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class BusinessManagementTest extends TestCase
{
    /** @test */
    public function agent_can_view_business_branches_page(): void
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $response = $this->get(route('business.branches'));
        $response->assertOk();
        $response->assertSee('Branches');
    }

    /** @test */
    public function agent_can_view_all_business_branches_list()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $noOfNewBranches = 5;
        Location::factory()->count($noOfNewBranches)->create();
        $totalBranches = Location::where('business_code', $user->business_code)->get();
        $totalBranchCount = $totalBranches->count();

        $this->actingAs($user);

        $response = $this->getJson(route('business.branches'),['X-Requested-With'=>'XMLHttpRequest']);
        $responseArray = json_decode($response->content(),'true');

        $allValuesFound = true;
        $firstArray = $totalBranches->toArray();
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
        $this->assertEquals($totalBranchCount,$responseArray['recordsTotal']);
    }

    /** @test */
    public function can_view_business_branches_create_page(): void
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $response = $this->get(route('business.branches.create'));
        $response->assertOk();
        $response->assertSee('Create Branches');
    }

    /** @test */
    public function agent_business_create_view_can_load_town_list()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $noOfTowns = 4;
        $region = Region::factory()->create();
        $towns = Towns::factory()->count($noOfTowns)->create(['region_code'=>$region->code]);

        $response = $this->get(route('business.branches.townlistAjax',['region_code' => $region->code]));

        $responseArray = json_decode($response->content(),'true');

        $allValuesFound = true;
        $firstArray = $towns->toArray();
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
        $this->assertEquals($noOfTowns,count($responseArray['data']));
    }

    /** @test */
    public function agent_business_create_view_can_load_area_list()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $noOfAreas = 4;
        $town = Towns::factory()->create();
        $areas = Area::factory()->count($noOfAreas)->create(['town_code'=>$town->code]);

        $response = $this->get(route('business.branches.arealistAjax',['town_code' => $town->code]));

        $responseArray = json_decode($response->content(),'true');

        $allValuesFound = true;
        $firstArray = $areas->toArray();
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
        $this->assertEquals($noOfAreas,count($responseArray['data']));
    }

    /** @test */
    public function agent_can_add_a_business_branch()
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0, 'business_code'=>$business->code]);

        $this->actingAs($user);

        $this->session(['currency'=>'TZS']);

        $region = Region::factory()->create();
        $town = Towns::factory()->create(['region_code'=>$region->code]);
        $area = Area::factory()->create(['region_code'=>$region->code,'town_code'=>$town->code]);
        $editData = [
            'business_code' => $business->code,
            'name' => $business->code . ' branch',
            'balance' => fake()->numberBetween(500000, 5000000),
            'balance_currency' => 'TZS',
            'ad_region' => $region->code,
            'ad_town' => $town->code,
            'ad_area' => $area->code,
        ];

        $response = $this->post(route('business.branches.create.submit',$editData));

        $data = [
            'business_code' => $editData['business_code'],
            'name' => $editData['name'],
            'balance' => $editData['balance'],
            'balance_currency' => $editData['balance_currency'],
            'region_code' => $editData['ad_region'],
            'town_code' => $editData['ad_town'],
            'area_code' => $editData['ad_area'],
        ];
        $this->assertDatabaseHas('locations', $data);
    }

    /** @test */
    public function agent_can_view_business_branches_edit_page(): void
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $branch = Location::factory()->create(['business_code'=>$user->business_code]);//must have

        $this->actingAs($user);

        $response = $this->get(route('business.branches.edit', $branch->id));
        $response->assertOk();
        $response->assertSee('Edit Branches');
    }

    /** @test */
    public function agent_can_edit_business_branch_successfully()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $region = Region::factory()->create();
        $town = Towns::factory()->create(['region_code'=>$region->code]);
        $area = Area::factory()->create(['region_code'=>$region->code,'town_code'=>$town->code]);

        $location = Location::factory()->create(['business_code'=>$user->business_code]);//must have
        $this->session(['currency'=>$location->balance_currency]);

        $editPostData = [
            'branches_id' => $location->id,
            'name' => 'edited name',
            'balance' => 10000,
            'availability_desc' => fake()->sentence.'_edited',
            'ad_region' => $region->code,
            'ad_town' => $town->code,
            'ad_area' => $area->code,
        ];

        $response = $this->post(route('business.branches.edit.submit',$editPostData));

        $response->assertRedirect(route('business.branches'));
        $data = [
            'id' => $location->id,
            'code' => $location->code,
            'business_code' => $user->business_code,
            'name' => $editPostData['name'],
            'balance' => $editPostData['balance'],
            'balance_currency' => $location->balance_currency,
            'region_code' => $region->code,
            'town_code' => $town->code,
            'area_code' => $area->code,
            'description' => $editPostData['availability_desc'],
        ];
        $this->assertDatabaseHas('locations', $data);

        //Only authorized
        $unauthorizedUser = User::factory()->create(['business_code'=>Business::factory()->create()->code]);
        $this->actingAs($unauthorizedUser);
        $location = Location::factory()->create(['business_code'=>$user->business_code,'description'=>'description content']);//must have
        $editPostData['branches_id'] = $location->id;
        $editPostData['availability_desc'] = 'New Description';
        $response = $this->post(route('business.branches.edit.submit',$editPostData));
        $this->assertTrue(session('errors')->first() == 'Not authorized to perform business action');
        $data = [
            'code' => $location->code,
            'description' => $location->description,
        ];
        $this->assertDatabaseHas('locations', $data);

    }

    /** @test */
    public function agent_can_delete_a_business_branch_with_soft_delete()
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0, 'business_code'=>$business->code]);

        $this->actingAs($user);

        $location = Location::factory()->create(['business_code'=> $business->code]);

        $response = $this->get(route('business.branches.delete',['id'=>$location->id]));

        $this->assertDatabaseHas('locations',['id'=>$location->id]);
        $locationsTable = DB::table('locations')->where('id', $location->id)->first();
        $this->assertNotNull($locationsTable->deleted_at);
        $this->assertNotContains(['id'=>$location->id], Location::get()->toArray());

        //Only authorized
        $unauthorizedUser = User::factory()->create(['business_code'=>Business::factory()->create()->code]);
        $this->actingAs($unauthorizedUser);
        $location = Location::factory()->create(['business_code'=> $business->code]);
        $response = $this->get(route('business.branches.delete',['id'=>$location->id]));
        $this->assertTrue(session('errors')->first() == 'Not authorized to perform business action');
        $locationsTable = DB::table('locations')->where('id', $location->id)->first();
        $this->assertNull($locationsTable->deleted_at);
    }


    /** @test */
    public function agent_can_view_business_profile_page(): void
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $response = $this->get(route('business.profile.update'));
        $response->assertOk();
        $response->assertSee('Business Profile');
    }

    /** @test */
    public function agent_can_view_correct_business_data_on_business_profile_page(): void
    {
        $business = Business::factory()->create([
            'tax_id' => 'tax_id_0000',
            'business_regno' => 'regno_0000',
            'business_phone_number' => '0763123123',
            'business_email' => 'test@test.com',
        ]);
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0, 'business_code'=>$business->code]);

        $this->actingAs($user);

        $response = $this->get(route('business.profile.update'));
        $response->assertOk();
        $response->assertSee($business->business_name);
        $response->assertSee($business->tax_id);
        $response->assertSee($business->business_regno);
        $response->assertSee($business->business_phone_number);
        $response->assertSee($business->business_email);
        $response->assertSee($business->business_location);
    }

    /** @test */
    public function agent_can_edit_business_profile_data()
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0,'business_code'=>$business->code]);

        $this->actingAs($user);

        $editPostData = [
            'business_id' => $business->id,
            'business_name' => 'business name edited',
            'tax_id' => '123-123-123',
            'business_regno' => 'reg no',
            'business_phone_number' => '0753123123',
            'business_email' => 'emailedited@test.com',
            'business_location_' => 'location address edited',
        ];

        $response = $this->post(route('business.profile.update.submit',$editPostData));

        $response->assertRedirect(route('business.profile.update'));
//        var_dump($response->getContent());
        $data = [
            'id' => $business->id,
            'business_name' => $editPostData['business_name'],
            'tax_id' => $editPostData['tax_id'],
            'business_regno' => $editPostData['business_regno'],
            'business_phone_number' => $editPostData['business_phone_number'],
            'business_email' => $editPostData['business_email'],
            'business_location' => $editPostData['business_location_'],
        ];
        $this->assertDatabaseHas('businesses', $data);

        //Only authorized
        $unauthorizedUser = User::factory()->create(['business_code'=>Business::factory()->create()->code]);
        $this->actingAs($unauthorizedUser);
        $editPostData['business_location_'] = 'new location';
        $response = $this->post(route('business.profile.update.submit',$editPostData));
        $this->assertTrue(session('errors')->first() == 'Not authorized to perform business action');
        $this->assertDatabaseHas('businesses', $data);

    }
}

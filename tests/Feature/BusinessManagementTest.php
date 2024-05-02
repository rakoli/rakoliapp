<?php

namespace Tests\Feature;

use App\Models\Area;
use App\Models\Business;
use App\Models\BusinessRole;
use App\Models\ExchangeAds;
use App\Models\ExchangeBusinessMethod;
use App\Models\Location;
use App\Models\Package;
use App\Models\Region;
use App\Models\Towns;
use App\Models\User;
use App\Utils\Enums\BusinessStatusEnum;
use App\Utils\Enums\ExchangeStatusEnum;
use App\Utils\Enums\UserTypeEnum;
use App\Utils\StatisticsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;

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
        Location::factory()->count($noOfNewBranches)->create(['business_code'=>$user->business_code]);
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
        $this->assertDatabaseHas($location->getTable(), $data);

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
        $this->assertDatabaseHas($location->getTable(), $data);

    }

    /** @test */
    public function agent_can_delete_a_business_branch_with_soft_delete()
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0, 'business_code'=>$business->code]);

        $this->actingAs($user);

        $location = Location::factory()->create(['business_code'=> $business->code]);

        $response = $this->get(route('business.branches.delete',['id'=>$location->id]));

        $this->assertDatabaseHas($location->getTable(),['id'=>$location->id]);
        $locationsTable = DB::table($location->getTable())->where('id', $location->id)->first();
        $this->assertNotNull($locationsTable->deleted_at);
        $this->assertNotContains(['id'=>$location->id], Location::get()->toArray());

        //Only authorized
        $unauthorizedUser = User::factory()->create(['business_code'=>Business::factory()->create()->code]);
        $this->actingAs($unauthorizedUser);
        $location = Location::factory()->create(['business_code'=> $business->code]);
        $response = $this->get(route('business.branches.delete',['id'=>$location->id]));
        $this->assertTrue(session('errors')->first() == 'Not authorized to perform business action');
        $locationsTable = DB::table($location->getTable())->where('id', $location->id)->first();
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

        $data = [
            'id' => $business->id,
            'business_name' => $editPostData['business_name'],
            'tax_id' => $editPostData['tax_id'],
            'business_regno' => $editPostData['business_regno'],
            'business_phone_number' => $editPostData['business_phone_number'],
            'business_email' => $editPostData['business_email'],
            'business_location' => $editPostData['business_location_'],
        ];
        $this->assertDatabaseHas($business->getTable(), $data);

        //Only authorized
        $unauthorizedUser = User::factory()->create(['business_code'=>Business::factory()->create()->code]);
        $this->actingAs($unauthorizedUser);
        $editPostData['business_location_'] = 'new location';
        $response = $this->post(route('business.profile.update.submit',$editPostData));
        $this->assertTrue(session('errors')->first() == 'Not authorized to perform business action');
        $this->assertDatabaseHas($business->getTable(), $data);

    }

    /** @test */
    public function agent_can_view_business_finance_page(): void
    {
        $business = Business::factory()->create(['balance'=>30000]);
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0, 'business_code'=>$business->code]);

        $this->actingAs($user);

        $response = $this->get(route('business.finance'));
        $response->assertOk();
        $response->assertSee('Finance');
        $response->assertSee(number_format(30000));
    }

    ////////CONTINUE FINANCE TEST




    /** @test */
    public function agent_can_view_business_users_page(): void
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $response = $this->get(route('business.users'));
        $response->assertOk();
        $response->assertSee('Users');

    }

    /** @test */
    public function agent_can_view_all_business_users_list()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $noOfNewUsers = 5;
        $userList = User::factory()->count($noOfNewUsers)->create(['business_code'=>$user->business_code]);
        $totalUsers = User::where('business_code', $user->business_code)->get();
        $totalUsersCount = $totalUsers->count();

        $this->actingAs($user);

        $response = $this->getJson(route('business.users'),['X-Requested-With'=>'XMLHttpRequest']);
        $responseArray = json_decode($response->content(),'true');

        $allValuesFound = true;
        $firstArray = $totalUsers->toArray();
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
        $this->assertEquals($totalUsersCount,$responseArray['recordsTotal']);
    }

    /** @test */
    public function agent_can_view_add_business_users_page(): void
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $response = $this->get(route('business.users.create'));
        $response->assertOk();
        $response->assertSee('Add Business User');

    }

    /** @test */
    public function agent_can_successfully_add_a_business_user(): void
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $branches = Location::factory()->count(2)->create(['business_code'=>$user->business_code])->pluck('code')->toArray();
        $roleCode = BusinessRole::factory()->create(['business_code'=>$user->business_code])->code;

        $data = [
            'fname' => fake()->firstName,
            'lname' => fake()->lastName,
            'email' => fake()->email,
            'phone' => fake()->numerify("25576#######"),
            'password' => Hash::make('12345678'),
            'branches' => $branches,
            'roles' => $roleCode,
        ];

        $response = $this->post(route('business.users.create.submit', $data));
        $response->assertRedirect(route('business.users'));
        $testData = [
            'business_code' => $user->business_code,
            'email' => $data['email'],
            'phone' => $data['phone']
        ];
        $this->assertDatabaseHas('users', $testData);
        $userToTest = User::where($testData)->first();
        foreach ($branches as $branch) {
            $this->assertDatabaseHas('location_users', [
                'user_code' => $userToTest->code,
                'location_code' => $branch,
            ]);
        }
        $this->assertDatabaseHas('user_roles', [
            'user_code' => $userToTest->code,
            'user_role' => $roleCode,
        ]);

    }

    /** @test */
    public function agent_can_view_edit_business_user_page(): void
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0,'business_code'=>$business->code]);

        $this->actingAs($user);

        $response = $this->get(route('business.users.edit', $user->id));
        $response->assertOk();
        $response->assertSee('Edit Business User');

    }

    /** @test */
    public function agent_can_successfully_edit_business_user_page(): void
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0,'business_code'=>$business->code]);

        $this->actingAs($user);

        $branches = Location::factory()->count(2)->create(['business_code'=>$user->business_code])->pluck('code')->toArray();
        $roleCode = BusinessRole::factory()->create(['business_code'=>$user->business_code])->code;

        $data = [
            'users_id' => $user->id,
            'fname' => 'edit'.fake()->firstName,
            'lname' => 'edit'.fake()->lastName,
            'email' => 'edit'.fake()->email,
            'phone' => fake()->numerify("25576#######"),
            'password' => Hash::make('12345678'),
            'branches' => $branches,
            'roles' => $roleCode,
        ];

        $response = $this->post(route('business.users.edit.submit', $data));

        $response->assertRedirect(route('business.users'));
        $testData = [
            'business_code' => $user->business_code,
            'email' => $data['email'],
            'phone' => $data['phone']
        ];
        $this->assertDatabaseHas($user->getTable(), $testData);
        foreach ($branches as $branch) {
            $this->assertDatabaseHas('location_users', [
                'user_code' => $user->code,
                'location_code' => $branch,
            ]);
        }
        $this->assertDatabaseHas('user_roles', [
            'user_code' => $user->code,
            'user_role' => $roleCode,
        ]);


        //Only authorized
        $unauthorizedUser = User::factory()->create(['business_code'=>Business::factory()->create()->code]);
        $this->actingAs($unauthorizedUser);
        $response = $this->post(route('business.users.edit.submit', $data));
        $this->assertTrue(session('errors')->first() == 'Not authorized to perform business action');

    }

    /** @test */
    public function agent_can_successfully_delete_business_user_with_softdelete(): void
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0,'business_code'=>$business->code]);

        $this->actingAs($user);

        $userToDelete = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0,'business_code'=>$business->code]);

        $response = $this->get(route('business.users.delete', $userToDelete->id));

        $response->assertRedirect(route('business.users'));
        $this->assertDatabaseHas($user->getTable(),['id'=>$userToDelete->id]);
        $usersTable = DB::table($user->getTable())->where('id', $userToDelete->id)->first();
        $this->assertNotNull($usersTable->deleted_at);
        $this->assertNotContains(['id'=>$userToDelete->id], User::get()->toArray());

        //Cannot self delete
        $response = $this->get(route('business.users.delete', $user->id));
        $this->assertTrue(session('errors')->first() == 'You can not delete you own account');

        //Only authorized
        $unauthorizedUser = User::factory()->create(['business_code'=>Business::factory()->create()->code]);
        $this->actingAs($unauthorizedUser);
        $userToDelete = User::factory()->create(['business_code'=> $business->code]);
        $response = $this->get(route('business.users.delete', $userToDelete->id));
        $this->assertTrue(session('errors')->first() == 'Not authorized to perform business action');
        $locationsTable = DB::table($user->getTable())->where('id', $userToDelete->id)->first();
        $this->assertNull($locationsTable->deleted_at);
    }

    /** @test */
    public function agent_can_view_business_roles_page(): void
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $response = $this->get(route('business.role'));
        $response->assertOk();
        $response->assertSee('Business Roles');

    }

    /** @test */
    public function agent_can_view_all_business_role_datatable_list()
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0, 'business_code'=>$business->code]);

        $noOfNewRoles = 5;
        BusinessRole::factory()->count($noOfNewRoles)->create(['business_code'=>$user->business_code]);
        $totalRoles = BusinessRole::where('business_code', $user->business_code)->get();
        $totalRolesCount = $totalRoles->count();

        $this->actingAs($user);

        $response = $this->getJson(route('business.role'),['X-Requested-With'=>'XMLHttpRequest']);
        $responseArray = json_decode($response->content(),'true');

        $allValuesFound = true;
        $firstArray = $totalRoles->toArray();
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
        $this->assertEquals($totalRolesCount,$responseArray['recordsTotal']);
    }

    /** @test */
    public function agent_can_add_business_roles_successfully(): void
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $data = [
            'name' => 'sample role',
            'description' => 'role description here'
        ];

        $response = $this->post(route('business.roles.add',$data));

        $response->assertRedirect(route('business.role'));
        $this->assertDatabaseHas('business_roles',[
            'business_code'=>$user->business_code,
            'name'=>$data['name'],
            'description'=>$data['description'],
        ]);
    }

    /** @test */
    public function agent_can_edit_business_role_data_successfully()
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0,'business_code'=>$business->code]);

        $this->actingAs($user);

        $editBusinessRole = BusinessRole::factory()->create(['business_code'=>$user->business_code]);

        $editPostData = [
            'edit_id' => $editBusinessRole->id,
            'edit_name' => 'edited name',
            'edit_description' => 'edited description',
        ];

        $response = $this->post(route('business.roles.edit',$editPostData));

        $response->assertRedirect(route('business.role'));

        $data = [
            'id' => $editBusinessRole->id,
            'name' => $editPostData['edit_name'],
            'description' => $editPostData['edit_description'],
        ];
        $this->assertDatabaseHas($editBusinessRole->getTable(), $data);

        //Only authorized
        $unauthorizedUser = User::factory()->create(['business_code'=>Business::factory()->create()->code]);
        $this->actingAs($unauthorizedUser);
        $editPostData['edit_name'] = 'new edit name';
        $response = $this->post(route('business.roles.edit',$editPostData));
        $this->assertTrue(session('errors')->first() == 'Not authorized to perform business action');
        $this->assertDatabaseHas($editBusinessRole->getTable(), $data);

    }

    /** @test */
    public function agent_can_successfully_delete_business_role_with_softdelete(): void
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0,'business_code'=>$business->code]);

        $this->actingAs($user);

        $roleToDelete = BusinessRole::factory()->create(['business_code'=>$business->code]);

        $response = $this->post(route('business.roles.delete', ['delete_id'=>$roleToDelete->id]));

        $response->assertRedirect(route('business.role'));
        $this->assertDatabaseHas($roleToDelete->getTable(),['id'=>$roleToDelete->id]);
        $usersTable = DB::table($roleToDelete->getTable())->where('id', $roleToDelete->id)->first();
        $this->assertNotNull($usersTable->deleted_at);
        $this->assertNotContains(['id'=>$roleToDelete->id], BusinessRole::get()->toArray());

        //Only authorized
        $unauthorizedUser = User::factory()->create(['business_code'=>Business::factory()->create()->code]);
        $this->actingAs($unauthorizedUser);
        $roleToDelete = BusinessRole::factory()->create(['business_code'=>$business->code]);
        $response = $this->post(route('business.roles.delete', ['delete_id'=>$roleToDelete->id]));
        $this->assertTrue(session('errors')->first() == 'Not authorized to perform business action');
        $locationsTable = DB::table($roleToDelete->getTable())->where('id', $roleToDelete->id)->first();
        $this->assertNull($locationsTable->deleted_at);
    }

    /** @test */
    public function agent_can_view_business_referrals_page_with_referral_link(): void
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $response = $this->get(route('business.referrals'));
        $response->assertOk();
        $response->assertSee('Referrals');
        $response->assertSee(route('referral.link', $user->business_code));

    }

    /** @test */
    public function agent_can_add_referral_successfully(): void
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $data = [
            'country_dial_code' => '+255',
            'fname' => fake()->firstName,
            'lname' => fake()->lastName,
            'phone' => fake()->numerify('076#######'),
            'email' => fake()->email,
        ];

        $response = $this->post(route('business.referrals.referr',$data));

        $response->assertRedirect(route('business.referrals'));
        $this->assertDatabaseHas('users',[
            'fname'=>$data['fname'],
            'lname'=>$data['lname'],
            'email'=>$data['email'],
            'referral_business_code'=>$user->business_code,
        ]);
    }

    /** @test */
    public function agent_can_view_all_referrals_datatable_list()
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0, 'business_code'=>$business->code]);

        $noOfReferrals = 4;
        User::factory()->count($noOfReferrals)->create(['referral_business_code'=>$business->code]);
        $totalReferralUsers = User::where('referral_business_code', $business->code)->get();
        $totalReferralUsersCount = $totalReferralUsers->count();

        $this->actingAs($user);

        $response = $this->getJson(route('business.referrals'),['X-Requested-With'=>'XMLHttpRequest']);
        $responseArray = json_decode($response->content(),'true');

        $allValuesFound = true;
        $firstArray = $totalReferralUsers->toArray();
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
        $this->assertEquals($totalReferralUsersCount,$responseArray['recordsTotal']);
    }

    /** @test */
    public function agent_can_view_business_correct_referrals_statistics(): void
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0, 'business_code'=>$business->code]);

        $this->actingAs($user);

        //Active Refer
        $noOfActive = 4;
        $activePackage = Package::where(['name'=>'prosperity','country_code'=>'TZ'])->first();
        for ($counter = 0;  $counter < $noOfActive ; $counter++) {
            $activeOne = Business::factory()->create([
                'package_code' => $activePackage->code,
                'package_expiry_at' => now()->addDays(random_int(30,300)),
                'referral_business_code' => $user->business_code
            ]);
            User::factory()->create([
                'business_code' => $activeOne->code,
                'referral_business_code' => $user->business_code,
            ]);
        }

        //InActive Refer
        $noOfInActive = 2;
        for ($counter = 0;  $counter < $noOfInActive ; $counter++) {
            $inActiveOne = Business::factory()->create([
                'package_code' => null,
                'package_expiry_at' => null,
                'referral_business_code' => $user->business_code
            ]);
            User::factory()->create([
                'business_code' => $inActiveOne->code,
                'referral_business_code' => $user->business_code,
            ]);

        }

        $statisticsService = new StatisticsService($user);

        $this->assertEquals($statisticsService->agent_total_number_of_referrals(),($noOfActive + $noOfInActive));
        $this->assertEquals($statisticsService->agent_total_annual_referral_commission(),($activePackage->price_commission * $noOfActive));
        $this->assertEquals($statisticsService->agent_total_no_of_inactive_referrals(),$noOfInActive);

    }



}

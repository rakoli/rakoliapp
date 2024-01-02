<?php

namespace Tests\Feature;

use App\Models\Area;
use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\ExchangeBusinessMethod;
use App\Models\ExchangeStat;
use App\Models\ExchangeTransaction;
use App\Models\Location;
use App\Models\Region;
use App\Models\Towns;
use App\Models\User;
use App\Utils\Enums\ExchangeStatusEnum;
use App\Utils\Enums\UserTypeEnum;
use Tests\TestCase;

class ExchangeModuleTest extends TestCase
{
    /** @test */
    public function agent_can_access_the_exchange_ads_page()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $response = $this->get(route('exchange.ads'));
        $response->assertOk();
        $response->assertSee('Exchange Advertisements');
    }

    /** @test */
    public function agent_can_access_an_exchange_ad_view_page()
    {
        $business = Business::factory()->has(ExchangeStat::factory(),'exchange_stats')->create();
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0,
                'business_code' => $business->code
            ]);

        $exchangeAd = ExchangeAds::factory()->create(['business_code'=>$business->code]);

        $this->actingAs($user);

        $response = $this->get(route('exchange.ads.view',$exchangeAd->id));
        $response->assertOk();
        $response->assertSee('Exchange Ad Detail');
    }

    /** @test */
    public function agent_can_access_exchange_transactions_page()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $response = $this->get(route('exchange.transactions'));
        $response->assertOk();
        $response->assertSee('Exchange Transactions');
    }

    /** @test */
    public function agent_can_access_an_exchange_transaction_view_page()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $exchangeTransaction = ExchangeTransaction::factory()->create(['trader_business_code'=>$user->business_code]);//must have

        $this->actingAs($user);

        $response = $this->get(route('exchange.transactions.view',$exchangeTransaction->id));
        $response->assertOk();
        $response->assertSee('Exchange Transaction Detail');
    }

    /** @test */
    public function agent_can_access_exchange_ad_posts_page()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $response = $this->get(route('exchange.posts'));
        $response->assertOk();
        $response->assertSee('Posts');
    }

    /** @test */
    public function agent_can_access_an_exchange_ad_post_add_page()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $response = $this->get(route('exchange.posts.create'));
        $response->assertOk();
        $response->assertSee('Create Post');
    }

    /** @test */
    public function agent_can_post_a_new_exchange_ad_post_without_location_data()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0, 'business_code'=>Business::factory()->create()->code]);

        $this->actingAs($user);

        $businessMethodIds = ExchangeBusinessMethod::factory()->count(3)->create(['business_code'=>$user->business_code])->pluck('id')->toArray();
        $response = $this->post(route('exchange.posts.create.submit'), [
            'ad_branch' => Location::factory()->create(['business_code'=>$user->business_code])->code,
            'availability_desc' => fake()->sentence,
            'ad_buy' => $businessMethodIds,
            'ad_sell' => $businessMethodIds,
            'amount_min' =>  random_int(1000,10000),
            'amount_max' => random_int(10000,100000),
            'description' => fake()->sentence,
            'terms' => fake()->sentence,
            'open_note' => fake()->sentence,
        ]);

        $response->assertRedirect(route('exchange.posts'));
        $this->assertDatabaseHas('exchange_ads', [
            'business_code' => $user->business_code,
        ]);

    }

    /** @test */
    public function agent_can_post_a_new_exchange_ad_post_with_location_data()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0, 'business_code'=>Business::factory()->create()->code]);

        $this->actingAs($user);

        $businessMethodIds = ExchangeBusinessMethod::factory()->count(3)->create(['business_code'=>$user->business_code])->pluck('id')->toArray();
        $region = Region::factory()->create();
        $town = Towns::factory()->create(['region_code'=>$region->code]);
        $area = Area::factory()->create(['region_code'=>$region->code,'town_code'=>$town->code]);
        $response = $this->post(route('exchange.posts.create.submit'), [
            'ad_branch' => Location::factory()->create(['business_code'=>$user->business_code])->code,
            'availability_desc' => fake()->sentence,
            'ad_buy' => $businessMethodIds,
            'ad_sell' => $businessMethodIds,
            'ad_region' => $region->code,
            'ad_town' => $town->code,
            'ad_area' => $area->code,
            'amount_min' =>  random_int(1000,10000),
            'amount_max' => random_int(10000,100000),
            'description' => fake()->sentence,
            'terms' => fake()->sentence,
            'open_note' => fake()->sentence,
        ]);

        $response->assertRedirect(route('exchange.posts'));
        $this->assertDatabaseHas('exchange_ads', [
            'business_code' => $user->business_code,
        ]);

    }

    /** @test */
    public function agent_can_access_an_exchange_ad_post_edit_page()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $exchangeAd = ExchangeAds::factory()->create(['business_code'=>$user->business_code]);//must have

        $this->actingAs($user);

        $response = $this->get(route('exchange.posts.edit',$exchangeAd->id));
        $response->assertOk();
        $response->assertSee('Edit Post');
    }

    /** @test */
    public function agent_can_edit_exchange_ad_post()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $businessMethodIds = ExchangeBusinessMethod::factory()->count(3)->create(['business_code'=>$user->business_code])->pluck('id')->toArray();
        $region = Region::factory()->create();
        $town = Towns::factory()->create(['region_code'=>$region->code]);
        $area = Area::factory()->create(['region_code'=>$region->code,'town_code'=>$town->code]);

        $exchangeAd = ExchangeAds::factory()->create(['business_code'=>$user->business_code]);//must have
        $editPostData = [
            'exchange_id' => $exchangeAd->id,
            'ad_status' => ExchangeStatusEnum::DISABLED,
            'ad_branch' => Location::factory()->create(['business_code'=>$user->business_code])->code,
            'availability_desc' => fake()->sentence.'_edited',
            'ad_region' => $region->code,
            'ad_town' => $town->code,
            'ad_area' => $area->code,
            'ad_buy' => $businessMethodIds,
            'ad_sell' => $businessMethodIds,
            'amount_min' => 5000,
            'amount_max' => 10000,
            'description' => fake()->sentence.'_edited',
            'terms' => fake()->sentence.'_edited',
            'open_note' => fake()->sentence.'_edited',
        ];

        $response = $this->post(route('exchange.posts.edit.submit',$editPostData));

        $response->assertRedirect(route('exchange.posts'));
        $data = [
            'id' => $exchangeAd->id,
            'business_code' => $user->business_code,
            'status' => $editPostData['ad_status'],
            'location_code' => $editPostData['ad_branch'],
            'availability_desc' => $editPostData['availability_desc'],
            'region_code' => $editPostData['ad_region'],
            'town_code' => $editPostData['ad_town'],
            'area_code' => $editPostData['ad_area'],
            'min_amount' => $editPostData['amount_min'],
            'max_amount' => $editPostData['amount_max'],
            'description' => $editPostData['description'],
            'terms' => $editPostData['terms'],
            'open_note' => $editPostData['open_note'],
        ];
        $this->assertDatabaseHas('exchange_ads', $data);
    }

    /** @test */
    public function agent_can_delete_exchange_ad_post()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $exchangeAd = ExchangeAds::factory()->create(['business_code'=>$user->business_code]);//must have

        $response = $this->get(route('exchange.posts.delete',$exchangeAd->id));

        $response->assertRedirect(route('exchange.posts'));
        $this->assertDatabaseHas('exchange_ads', [
            'id'=> $exchangeAd->id,
            'status'=>ExchangeStatusEnum::DELETED
        ]);
    }

    /** @test */
    public function agent_can_access_exchange_payments_method_page()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $response = $this->get(route('exchange.methods'));
        $response->assertOk();
        $response->assertSee('Payment Methods');
    }

    /** @test */
    public function agent_can_add_a_business_exchange_payments_method()
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0, 'business_code'=>$business->code]);

        $this->actingAs($user);

        $data = [
            'nickname' => 'cash',
            'method_name' => 'cash',
            'account_name' => fake()->name,
            'account_number' => fake()->numerify('###########'),
        ];
        $response = $this->post(route('exchange.methods.add',$data));

        $data['business_code'] = $business->code;
        $this->assertDatabaseHas('exchange_business_methods', $data);
    }

    /** @test */
    public function agent_can_edit_a_business_exchange_payments_method()
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0, 'business_code'=>$business->code]);

        $this->actingAs($user);

        $availableMethod = ExchangeBusinessMethod::factory()->create(['business_code'=> $business->code]);
        $data = [
            'id' => $availableMethod->id,
            'business_code' => $business->code,
            'nickname' => 'cash_edited',
            'method_name' => 'cash_edited',
            'account_name' => fake()->name.'_edited',
            'account_number' => fake()->numerify('###########'),
        ];
        $editPostData = [
            'edit_id' => $data['id'],
            'edit_nickname' => $data['nickname'],
            'edit_method_name' => $data['method_name'],
            'edit_account_name' => $data['account_name'],
            'edit_account_number' => $data['account_number'],
        ];
        $response = $this->post(route('exchange.methods.edit',$editPostData));

        $this->assertDatabaseHas('exchange_business_methods', $data);
    }

    /** @test */
    public function agent_can_delete_a_business_exchange_payments_method()
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0, 'business_code'=>$business->code]);

        $this->actingAs($user);

        $availableMethod = ExchangeBusinessMethod::factory()->create(['business_code'=> $business->code]);
        $response = $this->post(route('exchange.methods.delete',['delete_id'=>$availableMethod->id]));

        $this->assertDatabaseMissing('exchange_business_methods', ['id'=>$availableMethod->id]);
    }
}

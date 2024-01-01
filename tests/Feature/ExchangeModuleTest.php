<?php

namespace Tests\Feature;

use App\Models\ExchangeAds;
use App\Models\ExchangeTransaction;
use App\Models\User;
use App\Utils\Enums\UserTypeEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $exchangeAd = ExchangeAds::factory()->create();

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
    public function agent_can_access_exchange_payments_method_page()
    {
        $user = User::factory()->create(['type'=>UserTypeEnum::AGENT->value, 'registration_step'=>0]);

        $this->actingAs($user);

        $response = $this->get(route('exchange.methods'));
        $response->assertOk();
        $response->assertSee('Payment Methods');
    }
}

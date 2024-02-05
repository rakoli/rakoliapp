<?php

namespace Tests\Feature;

use App\Models\Area;
use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\ExchangeBusinessMethod;
use App\Models\ExchangeChat;
use App\Models\ExchangePaymentMethod;
use App\Models\ExchangeStat;
use App\Models\ExchangeTransaction;
use App\Models\Location;
use App\Models\Region;
use App\Models\Towns;
use App\Models\User;
use App\Utils\Enums\ExchangeStatusEnum;
use App\Utils\Enums\ExchangeTransactionStatusEnum;
use App\Utils\Enums\ExchangeTransactionTypeEnum;
use App\Utils\Enums\UserTypeEnum;
use Tests\TestCase;

class ExchangeModuleTest extends TestCase
{
    /** @test */
    public function agent_can_access_the_exchange_ads_market_page()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $this->actingAs($user);

        $response = $this->get(route('exchange.ads'));
        $response->assertOk();
        $response->assertSee('Exchange Advertisements');
    }

    /** @test */
    public function agent_exchange_ads_market_displays_all_active_ads()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $noOfNewAds = 5;
        ExchangeAds::factory()->count($noOfNewAds)->create();
        $totalAds = ExchangeAds::where('status', ExchangeStatusEnum::ACTIVE->value)->get();
        $totalAdsCount = $totalAds->count();

        $this->actingAs($user);

        $response = $this->getJson(route('exchange.ads'), ['X-Requested-With' => 'XMLHttpRequest']);
        $responseArray = json_decode($response->content(), 'true');

        $allValuesFound = true;
        $firstArray = $totalAds->toArray();
        $secondArray = $responseArray['data'];
        $secondArrayIds = [];
        foreach ($secondArray as $item) {
            array_push($secondArrayIds, $item['id']);
        }
        foreach ($firstArray as $firstArrayItem) {
            if (! in_array($firstArrayItem['id'], $secondArrayIds)) {
                $allValuesFound = false;
                break; // No need to continue checking if one value is not found
            }
        }

        $this->assertTrue($allValuesFound);
        $this->assertEquals($totalAdsCount, $responseArray['recordsTotal']);
    }

    /** @test */
    public function agent_can_access_an_exchange_ads_detail_page()
    {
        $business = Business::factory()->has(ExchangeStat::factory(), 'exchange_stats')->create();
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0,
            'business_code' => $business->code,
        ]);

        $exchangeAd = ExchangeAds::factory()->create(['business_code' => $business->code]);

        $this->actingAs($user);

        $response = $this->get(route('exchange.ads.view', $exchangeAd->id));
        $response->assertOk();
        $response->assertSee('Exchange Ad Detail');
    }

    /** @test */
    public function agent_can_open_a_new_trade_on_exchange_ads_detail_page()
    {
        $business = Business::factory()->has(ExchangeStat::factory(), 'exchange_stats')->create();
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0,
            'business_code' => $business->code,
        ]);

        $adBusiness = Business::factory()->has(User::factory(), 'user')->create();
        $exchangeAd = ExchangeAds::factory()->has(ExchangePaymentMethod::factory()->count(4), 'exchange_payment_methods')->create(['business_code' => $adBusiness->code, 'min_amount' => 1000, 'max_amount' => 100000]);
        $this->actingAs($user);
        $paymentMethodArray = $exchangeAd->exchange_payment_methods->toArray();
        $targetSelectId = fake()->randomElement($paymentMethodArray)['id'];
        $viaSelectId = fake()->randomElement($paymentMethodArray)['id'];
        $response = $this->post(route('exchange.ads.openorder', [
            'exchange_id' => $exchangeAd->id,
            'action_select' => ExchangeTransactionTypeEnum::BUY->value,
            'action_target_select' => $targetSelectId,
            'action_via_select' => $viaSelectId,
            'amount' => random_int(10000, 50000),
            'comment' => fake()->sentence,
        ]));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'result' => 'successful',
            'resultExplanation' => 'Order created successfully',
        ]);

        $this->assertDatabaseHas('exchange_transactions', [
            'exchange_ads_code' => $exchangeAd->code,
            'trader_business_code' => $user->business_code,
            'status' => ExchangeTransactionStatusEnum::OPEN,
        ]);
    }

    /** @test */
    public function agent_can_access_exchange_transactions_list_page()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $this->actingAs($user);

        $response = $this->get(route('exchange.transactions'));
        $response->assertOk();
        $response->assertSee('Exchange Transactions');
    }

    /** @test */
    public function agent_can_see_all_exchange_transactions_list_as_trader_and_owner()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0, 'business_code' => Business::factory()->create()->code]);

        //AS TRADER
        $noOfTransactions = 5;
        $transactions = ExchangeTransaction::factory()->count($noOfTransactions)->create(['trader_business_code' => $user->business_code]);

        $this->actingAs($user);

        $response = $this->getJson(route('exchange.transactions'), ['X-Requested-With' => 'XMLHttpRequest']);
        $responseArray = json_decode($response->content(), 'true');

        $allValuesFound = true;
        $firstArray = $transactions->toArray();
        $secondArray = $responseArray['data'];
        $secondArrayIds = [];
        foreach ($secondArray as $item) {
            array_push($secondArrayIds, $item['id']);
        }
        foreach ($firstArray as $firstArrayItem) {
            if (! in_array($firstArrayItem['id'], $secondArrayIds)) {
                $allValuesFound = false;
                break; // No need to continue checking if one value is not found
            }
        }

        $this->assertTrue($allValuesFound);
        $this->assertEquals($noOfTransactions, $responseArray['recordsTotal']);

        //AS OWNER
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0, 'business_code' => Business::factory()->create()->code]);
        $noOfTransactions = 6;

        $transactions = ExchangeTransaction::factory()->count($noOfTransactions)->create(['owner_business_code' => $user->business_code]);

        $this->actingAs($user);

        $response = $this->getJson(route('exchange.transactions'), ['X-Requested-With' => 'XMLHttpRequest']);
        $responseArray = json_decode($response->content(), 'true');

        $allValuesFound = true;
        $firstArray = $transactions->toArray();
        $secondArray = $responseArray['data'];
        $secondArrayIds = [];
        foreach ($secondArray as $item) {
            array_push($secondArrayIds, $item['id']);
        }
        foreach ($firstArray as $firstArrayItem) {
            if (! in_array($firstArrayItem['id'], $secondArrayIds)) {
                $allValuesFound = false;
                break; // No need to continue checking if one value is not found
            }
        }

        $this->assertTrue($allValuesFound);
        $this->assertEquals($noOfTransactions, $responseArray['recordsTotal']);
    }

    /** @test */
    public function agent_can_access_an_exchange_transaction_view_page()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $exchangeTransaction = ExchangeTransaction::factory()->create(['trader_business_code' => $user->business_code]); //must have

        $this->actingAs($user);

        $response = $this->get(route('exchange.transactions.view', $exchangeTransaction->id));
        $response->assertOk();
        $response->assertSee('Exchange Transaction Detail');

        //can only see authorized transaction
        $unathorizedUser = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0, 'business_code' => Business::factory()->create()->code]);
        $this->actingAs($unathorizedUser);
        $response = $this->get(route('exchange.transactions.view', $exchangeTransaction->id));
        $this->assertTrue(session('errors')->first() == 'Not authorized to access transaction');

    }

    /** @test */
    public function agent_can_view_chat_messages_on_transaction_view_page()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $exchangeTransaction = ExchangeTransaction::factory()->create(['trader_business_code' => $user->business_code]); //must have

        $this->actingAs($user);

        $noOfChatMessages = 3;
        $chats = ExchangeChat::factory()->count($noOfChatMessages)->create(['exchange_trnx_id' => $exchangeTransaction->id]);
        $response = $this->get(route('exchange.transactions.view', $exchangeTransaction->id));

        foreach ($chats as $chat) {
            $response->assertSee($chat->message);
        }
    }

    /** @test */
    public function agent_can_access_and_send_message_on_exchange_transaction_view_page()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $exchangeTransaction = ExchangeTransaction::factory()->create(['trader_business_code' => $user->business_code]); //must have

        $this->actingAs($user);

        $chatMessage = fake()->sentence;
        $response = $this->get(route('exchange.transactions.receive.message', [
            'ex_trans_id' => $exchangeTransaction->id,
            'message' => $chatMessage,
        ]));

        $this->assertDatabaseHas('exchange_chats', [
            'exchange_trnx_id' => $exchangeTransaction->id,
            'sender_code' => $user->code,
            'message' => $chatMessage,
        ]);
    }

    /** @test */
    public function agent_can_not_send_message_on_authorized_exchange_transaction_()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $exchangeTransaction = ExchangeTransaction::factory()->create(
            [
                'trader_business_code' => Business::factory()->create()->code,
                'owner_business_code' => Business::factory()->create()->code,
            ]); //must have

        $this->actingAs($user);

        $chatMessage = fake()->sentence;
        $response = $this->get(route('exchange.transactions.receive.message', [
            'ex_trans_id' => $exchangeTransaction->id,
            'message' => $chatMessage,
        ]));

        $this->assertTrue(session('errors')->first() == 'Not authorized to access transaction');

    }

    /** @test */
    public function agent_can_cancel_trade_on_exchange_transaction_view_page()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0, 'business_code' => Business::factory()->has(ExchangeStat::factory(), 'exchange_stats')->create()->code]);

        $exchangeTransaction = ExchangeTransaction::factory()->create(
            [
                'trader_business_code' => $user->business_code,
                'is_complete' => 0,
                'status' => ExchangeTransactionStatusEnum::OPEN->value,
            ]); //must have

        $this->actingAs($user);

        $response = $this->post(route('exchange.transactions.action', [
            'ex_trans_id' => $exchangeTransaction->id,
            'action' => 'cancel',
        ]));

        $this->assertDatabaseHas('exchange_transactions', [
            'id' => $exchangeTransaction->id,
            'status' => ExchangeTransactionStatusEnum::CANCELLED->value,
            'is_complete' => 1,
        ]);

    }

    /** @test */
    public function agent_can_complete_trade_on_exchange_transaction_view_page()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0, 'business_code' => Business::factory()->has(ExchangeStat::factory(), 'exchange_stats')->create()->code]);
        $ownerUser = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0, 'business_code' => Business::factory()->has(ExchangeStat::factory(), 'exchange_stats')->create()->code]);

        $exchangeTransaction = ExchangeTransaction::factory()->create(
            [
                'trader_business_code' => $user->business_code,
                'owner_business_code' => $ownerUser->business_code,
                'is_complete' => 0,
                'status' => ExchangeTransactionStatusEnum::OPEN->value,
            ]); //must have

        $this->actingAs($user);
        $response = $this->post(route('exchange.transactions.action', [
            'ex_trans_id' => $exchangeTransaction->id,
            'action' => 'complete',
        ]));

        //Should be pending if one side as completed
        $this->assertDatabaseHas('exchange_transactions', [
            'id' => $exchangeTransaction->id,
            'status' => ExchangeTransactionStatusEnum::PENDING_RELEASE->value,
            'is_complete' => 0,
        ]);

        $this->actingAs($ownerUser);
        $response = $this->post(route('exchange.transactions.action', [
            'ex_trans_id' => $exchangeTransaction->id,
            'action' => 'complete',
        ]));

        //Should be complete
        $this->assertDatabaseHas('exchange_transactions', [
            'id' => $exchangeTransaction->id,
            'status' => ExchangeTransactionStatusEnum::COMPLETED->value,
            'is_complete' => 1,
        ]);

    }

    /** @test */
    public function agent_cannot_perform_action_on_completed_trade_on_exchange_transaction_view_page()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $exchangeTransaction = ExchangeTransaction::factory()->create(
            [
                'trader_business_code' => $user->business_code,
                'is_complete' => 1,
                'status' => ExchangeTransactionStatusEnum::COMPLETED->value,
            ]); //must have

        $this->actingAs($user);
        $response = $this->post(route('exchange.transactions.action', [
            'ex_trans_id' => $exchangeTransaction->id,
            'action' => 'cancel',
        ]));

        $this->assertTrue(session('errors')->first() == 'Trade Already Completed');
    }

    /** @test */
    public function agent_cannot_perform_action_on_another_unauthorized_business()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $exchangeTransaction = ExchangeTransaction::factory()->create(
            [
                'trader_business_code' => Business::factory()->create()->code,
                'owner_business_code' => Business::factory()->create()->code,
            ]); //must have

        $this->actingAs($user);
        $response = $this->post(route('exchange.transactions.action', [
            'ex_trans_id' => $exchangeTransaction->id,
            'action' => 'cancel',
        ]));

        $this->assertTrue(session('errors')->first() == 'Not authorized to access transaction');
    }

    /** @test */
    public function agent_cannot_give_feedback_on_another_unauthorized_business()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);
        $exchangeTransaction = ExchangeTransaction::factory()->create(
            [
                'trader_business_code' => Business::factory()->create()->code,
                'owner_business_code' => Business::factory()->create()->code,
            ]); //must have

        $this->actingAs($user);
        $commentSentence = fake()->sentence;
        $response = $this->post(route('exchange.transactions.feedback.action', [
            'ex_trans_id' => $exchangeTransaction->id,
            'feedback' => 1,
            'comments' => $commentSentence,
        ]));

        $this->assertTrue(session('errors')->first() == 'Not authorized to access transaction');
    }

    /** @test */
    public function agent_cannot_give_feedback_more_than_once()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0, 'business_code' => Business::factory()->create()->code]);
        $owner = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0, 'business_code' => Business::factory()->create()->code]);
        $exchangeTransaction = ExchangeTransaction::factory()->create(
            [
                'trader_business_code' => $user->business_code,
                'owner_business_code' => $owner->business_code,
                'owner_submitted_feedback' => true,
                'trader_submitted_feedback' => true,
            ]); //must have

        $commentSentence = fake()->sentence;
        $this->actingAs($user);
        $response = $this->post(route('exchange.transactions.feedback.action', [
            'ex_trans_id' => $exchangeTransaction->id,
            'feedback' => 1,
            'comments' => $commentSentence,
        ]));
        $this->assertTrue(session('errors')->first() == 'Error! Feedback already submitted');

        $this->actingAs($owner);
        $response = $this->post(route('exchange.transactions.feedback.action', [
            'ex_trans_id' => $exchangeTransaction->id,
            'feedback' => 1,
            'comments' => $commentSentence,
        ]));
        $this->assertTrue(session('errors')->first() == 'Error! Feedback already submitted');
    }

    /** @test */
    public function agent_can_give_exchange_transaction_feedback_sucessfully()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0, 'business_code' => Business::factory()->has(ExchangeStat::factory(), 'exchange_stats')->create()->code]);
        $owner = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0, 'business_code' => Business::factory()->has(ExchangeStat::factory(), 'exchange_stats')->create()->code]);
        $exchangeTransaction = ExchangeTransaction::factory()->create(
            [
                'trader_business_code' => $user->business_code,
                'owner_business_code' => $owner->business_code,
            ]); //must have

        //TRADER Feedback
        $commentSentence = fake()->sentence;
        $this->actingAs($user);
        $response = $this->post(route('exchange.transactions.feedback.action', [
            'ex_trans_id' => $exchangeTransaction->id,
            'feedback' => 1,
            'comments' => $commentSentence,
        ]));
        $this->assertDatabaseHas('exchange_feedback', [
            'exchange_trnx_id' => $exchangeTransaction->id,
            'reviewed_business_code' => $owner->business_code,
            'review' => 1,
            'review_comment' => $commentSentence,
            'reviewer_user_code' => $user->code,
        ]);
        $this->assertDatabaseHas('exchange_transactions', [
            'id' => $exchangeTransaction->id,
            'trader_submitted_feedback' => 1,
        ]);

        //OWNER Feedback
        $this->actingAs($owner);
        $response = $this->post(route('exchange.transactions.feedback.action', [
            'ex_trans_id' => $exchangeTransaction->id,
            'feedback' => 0,
            'comments' => $commentSentence,
        ]));
        $this->assertDatabaseHas('exchange_feedback', [
            'exchange_trnx_id' => $exchangeTransaction->id,
            'reviewed_business_code' => $user->business_code,
            'review' => 0,
            'review_comment' => $commentSentence,
            'reviewer_user_code' => $owner->code,
        ]);
        $this->assertDatabaseHas('exchange_transactions', [
            'id' => $exchangeTransaction->id,
            'owner_submitted_feedback' => 1,
        ]);

    }

    /** @test */
    public function agent_can_access_exchange_ad_posts_page()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $this->actingAs($user);

        $response = $this->get(route('exchange.posts'));
        $response->assertOk();
        $response->assertSee('Posts');
    }

    /** @test */
    public function agent_business_exchange_ads_can_all_be_displayed()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0, 'business_code' => Business::factory()->create()->code]);

        $noOfAds = 5;
        $ads = ExchangeAds::factory()->count($noOfAds)->create(['business_code' => $user->business_code]);

        $this->actingAs($user);

        $response = $this->getJson(route('exchange.posts'), ['X-Requested-With' => 'XMLHttpRequest']);
        $responseArray = json_decode($response->content(), 'true');

        $allValuesFound = true;
        $firstArray = $ads->toArray();
        $secondArray = $responseArray['data'];
        $secondArrayIds = [];
        foreach ($secondArray as $item) {
            array_push($secondArrayIds, $item['id']);
        }
        foreach ($firstArray as $firstArrayItem) {
            if (! in_array($firstArrayItem['id'], $secondArrayIds)) {
                $allValuesFound = false;
                break; // No need to continue checking if one value is not found
            }
        }

        $this->assertTrue($allValuesFound);
        $this->assertEquals($noOfAds, $responseArray['recordsTotal']);
    }

    /** @test */
    public function agent_can_access_an_exchange_ad_post_add_page()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $this->actingAs($user);

        $response = $this->get(route('exchange.posts.create'));
        $response->assertOk();
        $response->assertSee('Create Post');
    }

    /** @test */
    public function agent_can_post_a_new_exchange_ad_post_without_location_data()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0, 'business_code' => Business::factory()->create()->code]);

        $this->actingAs($user);

        $businessMethodIds = ExchangeBusinessMethod::factory()->count(3)->create(['business_code' => $user->business_code])->pluck('id')->toArray();
        $response = $this->post(route('exchange.posts.create.submit'), [
            'ad_branch' => Location::factory()->create(['business_code' => $user->business_code])->code,
            'availability_desc' => fake()->sentence,
            'ad_buy' => $businessMethodIds,
            'ad_sell' => $businessMethodIds,
            'amount_min' => random_int(1000, 10000),
            'amount_max' => random_int(10000, 100000),
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
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0, 'business_code' => Business::factory()->create()->code]);

        $this->actingAs($user);

        $businessMethodIds = ExchangeBusinessMethod::factory()->count(3)->create(['business_code' => $user->business_code])->pluck('id')->toArray();
        $region = Region::factory()->create();
        $town = Towns::factory()->create(['region_code' => $region->code]);
        $area = Area::factory()->create(['region_code' => $region->code, 'town_code' => $town->code]);
        $response = $this->post(route('exchange.posts.create.submit'), [
            'ad_branch' => Location::factory()->create(['business_code' => $user->business_code])->code,
            'availability_desc' => fake()->sentence,
            'ad_buy' => $businessMethodIds,
            'ad_sell' => $businessMethodIds,
            'ad_region' => $region->code,
            'ad_town' => $town->code,
            'ad_area' => $area->code,
            'amount_min' => random_int(1000, 10000),
            'amount_max' => random_int(10000, 100000),
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
    public function agent_exchange_ad_view_can_load_town_list()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $this->actingAs($user);

        $noOfTowns = 4;
        $region = Region::factory()->create();
        $towns = Towns::factory()->count($noOfTowns)->create(['region_code' => $region->code]);

        $response = $this->get(route('exchange.post.townlistAjax', ['region_code' => $region->code]));

        $responseArray = json_decode($response->content(), 'true');

        $allValuesFound = true;
        $firstArray = $towns->toArray();
        $secondArray = $responseArray['data'];
        $secondArrayIds = [];
        foreach ($secondArray as $item) {
            array_push($secondArrayIds, $item['id']);
        }
        foreach ($firstArray as $firstArrayItem) {
            if (! in_array($firstArrayItem['id'], $secondArrayIds)) {
                $allValuesFound = false;
                break; // No need to continue checking if one value is not found
            }
        }

        $this->assertTrue($allValuesFound);
        $this->assertEquals($noOfTowns, count($responseArray['data']));
    }

    /** @test */
    public function agent_exchange_ad_view_can_load_area_list()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $this->actingAs($user);

        $noOfAreas = 4;
        $town = Towns::factory()->create();
        $areas = Area::factory()->count($noOfAreas)->create(['town_code' => $town->code]);

        $response = $this->get(route('exchange.post.arealistAjax', ['town_code' => $town->code]));

        $responseArray = json_decode($response->content(), 'true');

        $allValuesFound = true;
        $firstArray = $areas->toArray();
        $secondArray = $responseArray['data'];
        $secondArrayIds = [];
        foreach ($secondArray as $item) {
            array_push($secondArrayIds, $item['id']);
        }
        foreach ($firstArray as $firstArrayItem) {
            if (! in_array($firstArrayItem['id'], $secondArrayIds)) {
                $allValuesFound = false;
                break; // No need to continue checking if one value is not found
            }
        }

        $this->assertTrue($allValuesFound);
        $this->assertEquals($noOfAreas, count($responseArray['data']));
    }

    /** @test */
    public function agent_can_access_an_exchange_ad_post_edit_page()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $exchangeAd = ExchangeAds::factory()->create(['business_code' => $user->business_code]); //must have

        $this->actingAs($user);

        $response = $this->get(route('exchange.posts.edit', $exchangeAd->id));
        $response->assertOk();
        $response->assertSee('Edit Post');
    }

    /** @test */
    public function agent_can_edit_exchange_ad_post()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $this->actingAs($user);

        $businessMethodIds = ExchangeBusinessMethod::factory()->count(3)->create(['business_code' => $user->business_code])->pluck('id')->toArray();
        $region = Region::factory()->create();
        $town = Towns::factory()->create(['region_code' => $region->code]);
        $area = Area::factory()->create(['region_code' => $region->code, 'town_code' => $town->code]);

        $exchangeAd = ExchangeAds::factory()->create(['business_code' => $user->business_code]); //must have
        $editPostData = [
            'exchange_id' => $exchangeAd->id,
            'ad_status' => ExchangeStatusEnum::DISABLED,
            'ad_branch' => Location::factory()->create(['business_code' => $user->business_code])->code,
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

        $response = $this->post(route('exchange.posts.edit.submit', $editPostData));

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
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $this->actingAs($user);

        $exchangeAd = ExchangeAds::factory()->create(['business_code' => $user->business_code]); //must have

        $response = $this->get(route('exchange.posts.delete', $exchangeAd->id));

        $response->assertRedirect(route('exchange.posts'));
        $this->assertDatabaseHas('exchange_ads', [
            'id' => $exchangeAd->id,
            'status' => ExchangeStatusEnum::DELETED,
        ]);
    }

    /** @test */
    public function agent_can_access_exchange_payments_method_page()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0]);

        $this->actingAs($user);

        $response = $this->get(route('exchange.methods'));
        $response->assertOk();
        $response->assertSee('Payment Methods');
    }

    /** @test */
    public function agent_business_exchange_payments_methods_can_all_be_displayed()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0, 'business_code' => Business::factory()->create()->code]);

        $noOfMethods = 5;
        $ebm = ExchangeBusinessMethod::factory()->count($noOfMethods)->create(['business_code' => $user->business_code]);

        $this->actingAs($user);

        $response = $this->getJson(route('exchange.methods'), ['X-Requested-With' => 'XMLHttpRequest']);
        $responseArray = json_decode($response->content(), 'true');

        $allValuesFound = true;
        $firstArray = $ebm->toArray();
        $secondArray = $responseArray['data'];
        $secondArrayIds = [];
        foreach ($secondArray as $item) {
            array_push($secondArrayIds, $item['id']);
        }
        foreach ($firstArray as $firstArrayItem) {
            if (! in_array($firstArrayItem['id'], $secondArrayIds)) {
                $allValuesFound = false;
                break; // No need to continue checking if one value is not found
            }
        }

        $this->assertTrue($allValuesFound);
        $this->assertEquals($noOfMethods, $responseArray['recordsTotal']);
    }

    /** @test */
    public function agent_can_add_a_business_exchange_payments_method()
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0, 'business_code' => $business->code]);

        $this->actingAs($user);

        $data = [
            'nickname' => 'cash',
            'method_name' => 'cash',
            'account_name' => fake()->name,
            'account_number' => fake()->numerify('###########'),
        ];
        $response = $this->post(route('exchange.methods.add', $data));

        $data['business_code'] = $business->code;
        $this->assertDatabaseHas('exchange_business_methods', $data);
    }

    /** @test */
    public function agent_can_edit_a_business_exchange_payments_method()
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0, 'business_code' => $business->code]);

        $this->actingAs($user);

        $availableMethod = ExchangeBusinessMethod::factory()->create(['business_code' => $business->code]);
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
        $response = $this->post(route('exchange.methods.edit', $editPostData));

        $this->assertDatabaseHas('exchange_business_methods', $data);

        //Only authorized
        $unauthorizedUser = User::factory()->create(['business_code' => Business::factory()->create()->code]);
        $this->actingAs($unauthorizedUser);
        $response = $this->post(route('exchange.methods.edit', $editPostData));
        $this->assertTrue(session('errors')->first() == 'Not authorized to access method');
    }

    /** @test */
    public function agent_can_delete_a_business_exchange_payments_method()
    {
        $business = Business::factory()->create();
        $user = User::factory()->create(['type' => UserTypeEnum::AGENT->value, 'registration_step' => 0, 'business_code' => $business->code]);

        $this->actingAs($user);

        $availableMethod = ExchangeBusinessMethod::factory()->create(['business_code' => $business->code]);
        $response = $this->post(route('exchange.methods.delete', ['delete_id' => $availableMethod->id]));

        $this->assertDatabaseMissing('exchange_business_methods', ['id' => $availableMethod->id]);

        //Only authorized
        $unauthorizedUser = User::factory()->create(['business_code' => Business::factory()->create()->code]);
        $this->actingAs($unauthorizedUser);
        $availableMethod = ExchangeBusinessMethod::factory()->create(['business_code' => $business->code]);
        $response = $this->post(route('exchange.methods.delete', ['delete_id' => $availableMethod->id]));
        $this->assertTrue(session('errors')->first() == 'Not authorized to access method');
    }

    //ADMIN TEST
    /** @test */
    public function admin_can_access_the_exchange_ads_list_page()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::ADMIN->value, 'registration_step' => 0]);

        $this->actingAs($user);

        $response = $this->get(route('admin.exchange.ads'));
        $response->assertOk();
        $response->assertSee('Exchange Advertisements');
    }

    /** @test */
    public function admin_exchange_ads_market_displays_all_ads()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::ADMIN->value, 'registration_step' => 0]);

        $noOfNewAds = 5;
        ExchangeAds::factory()->count($noOfNewAds)->create();
        $totalAds = ExchangeAds::get();
        $totalAdsCount = $totalAds->count();

        $this->actingAs($user);

        $response = $this->getJson(route('admin.exchange.ads'), ['X-Requested-With' => 'XMLHttpRequest']);
        $responseArray = json_decode($response->content(), 'true');

        $allValuesFound = true;
        $firstArray = $totalAds->toArray();
        $secondArray = $responseArray['data'];
        $secondArrayIds = [];
        foreach ($secondArray as $item) {
            array_push($secondArrayIds, $item['id']);
        }
        foreach ($firstArray as $firstArrayItem) {
            if (! in_array($firstArrayItem['id'], $secondArrayIds)) {
                $allValuesFound = false;
                break; // No need to continue checking if one value is not found
            }
        }

        $this->assertTrue($allValuesFound);
        $this->assertEquals($totalAdsCount, $responseArray['recordsTotal']);
    }

    /** @test */
    public function admin_can_access_an_exchange_ad_post_edit_page()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::ADMIN->value, 'registration_step' => 0]);

        $exchangeAd = ExchangeAds::factory()->create(['business_code' => $user->business_code]); //must have

        $this->actingAs($user);

        $response = $this->get(route('admin.exchange.posts.edit', $exchangeAd->id));
        $response->assertOk();
        $response->assertSee('Edit Post');
    }

    /** @test */
    public function admin_can_edit_exchange_ad_post()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::ADMIN->value, 'registration_step' => 0]);

        $this->actingAs($user);

        $businessMethodIds = ExchangeBusinessMethod::factory()->count(3)->create(['business_code' => $user->business_code])->pluck('id')->toArray();
        $region = Region::factory()->create();
        $town = Towns::factory()->create(['region_code' => $region->code]);
        $area = Area::factory()->create(['region_code' => $region->code, 'town_code' => $town->code]);

        $exchangeAd = ExchangeAds::factory()->create(['business_code' => $user->business_code]); //must have
        $editPostData = [
            'exchange_id' => $exchangeAd->id,
            'ad_status' => ExchangeStatusEnum::DISABLED,
            'ad_branch' => Location::factory()->create(['business_code' => $user->business_code])->code,
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

        $response = $this->post(route('admin.exchange.posts.edit.submit', $editPostData));

        $response->assertRedirect(route('admin.exchange.ads'));
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
    public function admin_can_access_exchange_transactions_list_page()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::ADMIN->value, 'registration_step' => 0]);

        $this->actingAs($user);

        $response = $this->get(route('admin.exchange.transactions'));
        $response->assertOk();
        $response->assertSee('Transactions');
    }

    /** @test */
    public function admin_can_access_an_exchange_transaction_view_page()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::ADMIN->value, 'registration_step' => 0]);

        $exchangeTransaction = ExchangeTransaction::factory()->create(['trader_business_code' => $user->business_code]); //must have

        $this->actingAs($user);

        $response = $this->get(route('admin.exchange.transactions.view', $exchangeTransaction->id));
        $response->assertOk();
        $response->assertSee('Transaction View');
    }

    /** @test */
    public function admin_can_cancel_trade_on_exchange_transaction_view_page()
    {
        $traderBusiness = Business::factory()->has(ExchangeStat::factory(), 'exchange_stats')->create();
        $ownerBusiness = Business::factory()->has(ExchangeStat::factory(), 'exchange_stats')->create();
        $user = User::factory()->create(['type' => UserTypeEnum::ADMIN->value, 'registration_step' => 0]);

        $exchangeTransaction = ExchangeTransaction::factory()->create(
            [
                'is_complete' => 0,
                'status' => ExchangeTransactionStatusEnum::OPEN->value,
                'trader_business_code' => $traderBusiness->code,
                'owner_business_code' => $ownerBusiness->code,
            ]); //must have

        $this->actingAs($user);

        $response = $this->post(route('admin.exchange.transactions.action', [
            'ex_trans_id' => $exchangeTransaction->id,
            'action' => 'cancel',
        ]));

        $this->assertDatabaseHas('exchange_transactions', [
            'id' => $exchangeTransaction->id,
            'status' => ExchangeTransactionStatusEnum::CANCELLED->value,
            'is_complete' => 1,
        ]);

    }

    /** @test */
    public function admin_can_complete_trade_on_exchange_transaction_view_page()
    {
        $traderBusiness = Business::factory()->has(ExchangeStat::factory(), 'exchange_stats')->create();
        $ownerBusiness = Business::factory()->has(ExchangeStat::factory(), 'exchange_stats')->create();
        $user = User::factory()->create(['type' => UserTypeEnum::ADMIN->value, 'registration_step' => 0]);

        $exchangeTransaction = ExchangeTransaction::factory()->create(
            [
                'is_complete' => 0,
                'status' => ExchangeTransactionStatusEnum::OPEN->value,
                'trader_business_code' => $traderBusiness->code,
                'owner_business_code' => $ownerBusiness->code,
            ]); //must have

        $this->actingAs($user);
        $response = $this->post(route('admin.exchange.transactions.action', [
            'ex_trans_id' => $exchangeTransaction->id,
            'action' => 'complete',
        ]));

        $this->assertDatabaseHas('exchange_transactions', [
            'id' => $exchangeTransaction->id,
            'status' => ExchangeTransactionStatusEnum::COMPLETED->value,
            'is_complete' => 1,
        ]);
    }

    /** @test */
    public function admin_can_access_and_send_message_on_exchange_transaction_view_page()
    {
        $user = User::factory()->create(['type' => UserTypeEnum::ADMIN->value, 'registration_step' => 0]);

        $exchangeTransaction = ExchangeTransaction::factory()->create(['trader_business_code' => $user->business_code]); //must have

        $this->actingAs($user);

        $chatMessage = fake()->sentence;
        $response = $this->get(route('admin.exchange.transactions.receive.message', [
            'ex_trans_id' => $exchangeTransaction->id,
            'message' => $chatMessage,
        ]));

        $this->assertDatabaseHas('exchange_chats', [
            'exchange_trnx_id' => $exchangeTransaction->id,
            'sender_code' => $user->code,
            'message' => $chatMessage,
        ]);
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\Business;
use App\Models\Crypto;
use App\Models\FinancialServiceProvider;
use App\Models\Location;
use App\Models\Network;
use App\Models\User;
use App\Utils\Enums\NetworkTypeEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NetworkAPITest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $business;
    protected $location;
    protected $fsp;
    protected $crypto;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test data
        $this->business = Business::factory()->create();
        $this->location = Location::factory()->create([
            'business_code' => $this->business->code
        ]);
        $this->user = User::factory()->create([
            'business_code' => $this->business->code
        ]);
        $this->fsp = FinancialServiceProvider::factory()->create();
        $this->crypto = Crypto::factory()->create();

        // Authenticate user
        Sanctum::actingAs($this->user);
    }

    public function test_can_get_all_networks()
    {
        // Create test networks
        Network::factory()->create([
            'business_code' => $this->business->code,
            'location_code' => $this->location->code,
            'type' => NetworkTypeEnum::FINANCE,
            'fsp_code' => $this->fsp->code,
        ]);

        $response = $this->getJson('/api/networks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'code',
                        'name',
                        'type',
                        'location',
                        'fsp',
                        'created_at',
                        'updated_at'
                    ]
                ],
                'message'
            ]);
    }

    public function test_can_create_finance_network()
    {
        $data = [
            'name' => 'Test M-PESA Till',
            'type' => NetworkTypeEnum::FINANCE->value,
            'location_code' => $this->location->code,
            'fsp_code' => $this->fsp->code,
            'agent_no' => '12345',
            'balance' => 50000.00,
            'description' => 'Test finance network'
        ];

        $response = $this->postJson('/api/networks', $data);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Network created successfully'
            ]);

        $this->assertDatabaseHas('networks', [
            'name' => 'Test M-PESA Till',
            'type' => NetworkTypeEnum::FINANCE->value,
            'business_code' => $this->business->code
        ]);
    }

    public function test_can_create_crypto_network()
    {
        $data = [
            'name' => 'Test Bitcoin Wallet',
            'type' => NetworkTypeEnum::CRYPTO->value,
            'location_code' => $this->location->code,
            'crypto_code' => $this->crypto->code,
            'crypto_balance' => 0.5,
            'exchange_rate' => 45000000.00,
            'description' => 'Test crypto network'
        ];

        $response = $this->postJson('/api/networks', $data);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Network created successfully'
            ]);

        $this->assertDatabaseHas('networks', [
            'name' => 'Test Bitcoin Wallet',
            'type' => NetworkTypeEnum::CRYPTO->value,
            'business_code' => $this->business->code
        ]);
    }

    public function test_validation_fails_with_invalid_data()
    {
        $data = [
            'name' => '', // Required field
            'type' => 'Invalid Type', // Invalid type
            'location_code' => 'INVALID', // Non-existent location
        ];

        $response = $this->postJson('/api/networks', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'type', 'location_code']);
    }

    public function test_can_get_single_network()
    {
        $network = Network::factory()->create([
            'business_code' => $this->business->code,
            'location_code' => $this->location->code,
            'type' => NetworkTypeEnum::FINANCE,
            'fsp_code' => $this->fsp->code,
        ]);

        $response = $this->getJson("/api/networks/{$network->code}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'code' => $network->code,
                    'name' => $network->name
                ],
                'message' => 'Network retrieved successfully'
            ]);
    }

    public function test_can_update_network()
    {
        $network = Network::factory()->create([
            'business_code' => $this->business->code,
            'location_code' => $this->location->code,
            'type' => NetworkTypeEnum::FINANCE,
            'fsp_code' => $this->fsp->code,
        ]);

        $data = [
            'name' => 'Updated Network Name',
            'type' => NetworkTypeEnum::FINANCE->value,
            'location_code' => $this->location->code,
            'fsp_code' => $this->fsp->code,
            'description' => 'Updated description'
        ];

        $response = $this->putJson("/api/networks/{$network->code}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Network updated successfully'
            ]);

        $this->assertDatabaseHas('networks', [
            'code' => $network->code,
            'name' => 'Updated Network Name',
            'description' => 'Updated description'
        ]);
    }

    public function test_can_delete_network()
    {
        $network = Network::factory()->create([
            'business_code' => $this->business->code,
            'location_code' => $this->location->code,
            'type' => NetworkTypeEnum::FINANCE,
            'fsp_code' => $this->fsp->code,
        ]);

        $response = $this->deleteJson("/api/networks/{$network->code}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Network deleted successfully'
            ]);

        $this->assertSoftDeleted('networks', ['code' => $network->code]);
    }

    public function test_can_get_helper_data()
    {
        // Test locations endpoint
        $response = $this->getJson('/api/networks/data/locations');
        $response->assertStatus(200)->assertJsonStructure(['success', 'data', 'message']);

        // Test FSP endpoint
        $response = $this->getJson('/api/networks/data/financial-service-providers');
        $response->assertStatus(200)->assertJsonStructure(['success', 'data', 'message']);

        // Test cryptos endpoint
        $response = $this->getJson('/api/networks/data/cryptos');
        $response->assertStatus(200)->assertJsonStructure(['success', 'data', 'message']);

        // Test types endpoint
        $response = $this->getJson('/api/networks/data/types');
        $response->assertStatus(200)->assertJsonStructure(['success', 'data', 'message']);
    }

    public function test_cannot_access_other_business_networks()
    {
        // Create another business and network
        $otherBusiness = Business::factory()->create();
        $otherLocation = Location::factory()->create(['business_code' => $otherBusiness->code]);
        $otherNetwork = Network::factory()->create([
            'business_code' => $otherBusiness->code,
            'location_code' => $otherLocation->code,
            'type' => NetworkTypeEnum::FINANCE,
            'fsp_code' => $this->fsp->code,
        ]);

        // Try to access other business's network
        $response = $this->getJson("/api/networks/{$otherNetwork->code}");
        $response->assertStatus(404);

        // Try to update other business's network
        $response = $this->putJson("/api/networks/{$otherNetwork->code}", [
            'name' => 'Hacked Network'
        ]);
        $response->assertStatus(404);

        // Try to delete other business's network
        $response = $this->deleteJson("/api/networks/{$otherNetwork->code}");
        $response->assertStatus(404);
    }
}

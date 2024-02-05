<?php

namespace Database\Seeders;

use App\Models\ExchangeChat;
use App\Models\ExchangeTransaction;
use Illuminate\Database\Seeder;

class SampleExchangeTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExchangeTransaction::factory()
            ->has(ExchangeChat::factory()->count(2), 'exchange_chats')
            ->count(7)->create();

    }
}

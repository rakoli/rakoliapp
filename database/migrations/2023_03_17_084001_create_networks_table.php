<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('networks', function (Blueprint $table) {
            $table->id();
            $table->string('business_code');
            $table->foreign('business_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('location_code');
            $table->foreign('location_code')->references('code')
                ->on('locations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('fsp_code')->nullable();
            $table->foreign('fsp_code')->references('code')
                ->on('financial_service_providers')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('crypto_code')->nullable();
            $table->foreign('crypto_code')->references('code')
                ->on('cryptos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        
            $table->string('type'); // enum <NetworkTypeEnum<Finance, Crypto>
            $table->string('code')->unique();
            $table->string('agent_no')->index();
            $table->string('name');
            $table->double('balance', 12, 0)->default(0);
            $table->string('balance_currency')->nullable();
            $table->double('crypto_balance', 20, 10)->nullable();
            $table->double('exchange_rate', 20, 10)->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['location_code', 'fsp_code', 'agent_no'], 'uniq_agent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('networks');
    }
};

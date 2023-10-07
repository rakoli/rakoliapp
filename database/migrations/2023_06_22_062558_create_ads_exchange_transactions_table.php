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
        Schema::create('ads_exchange_transactions', function (Blueprint $table) {
            $table->id();

            $table->string('exchange_ads_code');
            $table->foreign('exchange_ads_code')->references('code')
                ->on('exchange_ads')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('buyer_code');
            $table->foreign('buyer_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('seller_code');
            $table->foreign('seller_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('user_code');
            $table->foreign('user_code')->references('code')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->decimal('amount',12,2);
            $table->string('status')->default('completed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads_exchange_transactions');
    }
};

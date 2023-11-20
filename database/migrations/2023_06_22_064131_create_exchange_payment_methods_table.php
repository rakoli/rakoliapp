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
        Schema::create('exchange_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('exchange_ads_code');
            $table->foreign('exchange_ads_code')->references('code')
                ->on('exchange_ads')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('method_name');
            $table->string('receive_account_number');
            $table->string('receive_account_name');
            $table->integer('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_payment_methods');
    }
};

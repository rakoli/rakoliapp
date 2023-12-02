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
        Schema::create('exchange_chats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('exchange_trnx_id')->unsigned();
            $table->foreign('exchange_trnx_id')->references('id')
                ->on('exchange_transactions')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();


            $table->string('sender_code');
            $table->foreign('sender_code')->references('code')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->text('message');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_chats');
    }
};

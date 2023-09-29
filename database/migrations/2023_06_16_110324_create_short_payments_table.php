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
        Schema::create('short_payments', function (Blueprint $table) {
            $table->id();
            $table->string('short_code');
            $table->foreign('short_code')->references('code')
                ->on('shorts')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('user_code');

            $table->foreign('user_code')->references('code')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->decimal('amount', 12 , 2);

            $table->string('description')->nullable();

            $table->text('notes')->invisible()->nullable();

            $table->string('payment_method')->nullable();

            $table->date('deposited_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('short_payments');
    }
};

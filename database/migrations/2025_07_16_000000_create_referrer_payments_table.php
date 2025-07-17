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
        Schema::create('referrer_payments', function (Blueprint $table) {
            $table->id();
            $table->string('user_code');
            $table->foreign('user_code')->references('code')->on('users');
            $table->decimal('amount', 12, 2);
            $table->string('payment_type'); // 'registration', 'first_week', 'second_week'
            $table->string('period'); // Format: 'YYYY-MM'
            $table->string('status')->default('pending'); // 'pending', 'paid', 'cancelled'
            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrer_payments');
    }
};

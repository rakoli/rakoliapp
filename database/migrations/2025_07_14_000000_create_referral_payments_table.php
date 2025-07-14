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
        Schema::create('referral_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Sales user earning the payment
            $table->foreignId('referral_id')->constrained('users')->onDelete('cascade'); // The referred user
            $table->decimal('amount', 10, 2); // Payment amount
            $table->enum('payment_type', ['registration_bonus', 'transaction_bonus_week1', 'transaction_bonus_week2']);
            $table->enum('payment_status', ['pending', 'paid', 'cancelled', 'partial'])->default('pending');
            $table->string('payment_method')->nullable(); // 'bank_transfer', 'mobile_money', 'cash'
            $table->string('payment_reference')->nullable(); // Transaction reference
            $table->text('notes')->nullable(); // Additional notes
            $table->timestamp('paid_at')->nullable(); // When payment was made
            $table->foreignId('processed_by')->nullable()->constrained('users'); // Admin who processed
            $table->timestamps();

            // Indexes for better performance
            $table->index(['user_id', 'payment_status']);
            $table->index(['payment_type', 'payment_status']);
            $table->index('paid_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_payments');
    }
};

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
        Schema::create('float_exchanges', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();

            // User and business info
            $table->string('user_code');
            $table->foreign('user_code')->references('code')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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

            // Shift reference
            $table->unsignedBigInteger('shift_id');
            $table->foreign('shift_id')->references('id')
                ->on('shifts')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // From network
            $table->string('from_network_code');
            $table->foreign('from_network_code')->references('code')
                ->on('networks')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('from_fsp_code');
            $table->foreign('from_fsp_code')->references('code')
                ->on('financial_service_providers')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // To network
            $table->string('to_network_code');
            $table->foreign('to_network_code')->references('code')
                ->on('networks')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('to_fsp_code');
            $table->foreign('to_fsp_code')->references('code')
                ->on('financial_service_providers')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // Amount and fee
            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 15, 2)->default(0); // 0.1% of amount
            $table->decimal('total_amount', 15, 2); // amount + fee
            $table->string('currency', 10);

            // Balances before and after
            $table->decimal('from_balance_before', 15, 2);
            $table->decimal('from_balance_after', 15, 2);
            $table->decimal('to_balance_before', 15, 2);
            $table->decimal('to_balance_after', 15, 2);

            // Status and notes
            $table->string('status')->default('completed'); // completed, failed, pending
            $table->text('notes')->nullable();

            $table->timestamps();

            // Indexes for better query performance
            $table->index(['user_code', 'created_at']);
            $table->index(['business_code', 'created_at']);
            $table->index(['shift_id', 'created_at']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('float_exchanges');
    }
};

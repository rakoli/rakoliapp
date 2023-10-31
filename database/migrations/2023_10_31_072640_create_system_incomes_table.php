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
        Schema::create('system_incomes', function (Blueprint $table) {
            $table->id();
            $table->string('country_code');
            $table->foreign('country_code')->references('code')
                ->on('countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('category');
            $table->decimal('amount', 12,2)->default('0.00');
            $table->string('amount_currency');
            $table->string('channel');
            $table->string('channel_reference');
            $table->string('channel_timestamp')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->default(\App\Utils\Enums\SystemIncomeStatusEnum::PENDING_VERIFICATION);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_incomes');
    }
};

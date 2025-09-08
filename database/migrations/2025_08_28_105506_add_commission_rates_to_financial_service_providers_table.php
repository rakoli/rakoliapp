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
        Schema::table('financial_service_providers', function (Blueprint $table) {
            $table->decimal('withdraw_commission_rate', 5, 4)->default(0.004)->comment('Withdraw commission rate as decimal (0.004 = 0.4%)');
            $table->decimal('deposit_commission_rate', 5, 4)->default(0.003)->comment('Deposit commission rate as decimal (0.003 = 0.3%)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_service_providers', function (Blueprint $table) {
            $table->dropColumn(['withdraw_commission_rate', 'deposit_commission_rate']);
        });
    }
};

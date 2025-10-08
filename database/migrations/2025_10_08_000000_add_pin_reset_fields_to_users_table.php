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
        Schema::table('users', function (Blueprint $table) {
            $table->string('pin_reset_otp')->nullable()->after('pin');
            $table->timestamp('pin_reset_otp_time')->nullable()->after('pin_reset_otp');
            $table->integer('pin_reset_otp_count')->default(0)->after('pin_reset_otp_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['pin_reset_otp', 'pin_reset_otp_time', 'pin_reset_otp_count']);
        });
    }
};

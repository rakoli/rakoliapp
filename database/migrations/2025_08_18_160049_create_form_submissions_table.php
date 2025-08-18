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
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('sales_rep_name');
            $table->string('agent_name');
            $table->string('phone_number', 20);
            $table->string('location');
            $table->string('gps_coordinates')->nullable();
            $table->boolean('location_captured')->default(false);
            $table->string('business_name');
            $table->json('mno_used')->nullable(); // Array of MNO providers used
            $table->string('other_mno')->nullable();
            $table->string('vodacom_till', 50)->nullable();
            $table->string('airtel_till', 50)->nullable();
            $table->string('tigo_till', 50)->nullable();
            $table->string('bank_wallet')->nullable();
            $table->string('visit_outcome');
            $table->text('decline_reason')->nullable();
            $table->text('key_concerns')->nullable();
            $table->text('suggestions')->nullable();
            $table->string('agent_signature')->nullable(); // Agent signature as string
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};

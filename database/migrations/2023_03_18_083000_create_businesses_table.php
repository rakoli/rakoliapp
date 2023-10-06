<?php

use App\Models\Country;
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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('country_code');
            $table->foreign('country_code')->references('code')
                ->on('countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('code');
            $table->string('type')->default('AGENT');
//            $table->string('walkthrough_step')->nullable()->default(\App\Utils\Enums\WalkThroughStepEnums::BUSINESS->value);
            $table->string('Business_name')->unique();
            $table->string('tax_id')->nullable()->unique();
            $table->string('Business_regno')->nullable()->unique();
            $table->string('Business_phone_number')->nullable()->unique();
            $table->string('Business_email')->nullable()->unique();
            $table->string("Business_Code")->nullable()->unique();
            $table->string("Package_Code")->nullable();
            $table->foreign('Package_Code')->references('code')
                ->on('packages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('Business_location')->nullable();
            $table->string('status')->default(\App\Utils\Enums\BusinessStatusEnum::ACTIVE->value);//1- Active, 0 - Disabled, 2 - Inactive
            $table->string('subscription_code')->nullable();
            $table->timestamp('expiry_at')->nullable();
            $table->decimal('balance',12,2)->default(0); //Earning from referral and VAS
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};

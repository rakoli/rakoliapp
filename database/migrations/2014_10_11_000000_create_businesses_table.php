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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('country_code');
            $table->foreign('country_code')->references('code')
                ->on('countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('code')->unique();
            $table->string('referral_business_code')->nullable();
            $table->string('type')->default(\App\Utils\Enums\BusinessTypeEnum::AGENCY->value);
            $table->boolean('is_verified')->default(0);
            $table->string('business_name')->index();
            $table->string('tax_id')->nullable()->index();
            $table->string('business_regno')->nullable()->index();
            $table->timestamp('business_reg_date')->nullable();
            $table->string('business_phone_number')->nullable()->index();
            $table->string('business_email')->nullable()->index();
            $table->string('package_code')->nullable();
            $table->foreign('package_code')->references('code')
                ->on('packages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamp('package_expiry_at')->nullable();
            $table->string('business_location')->nullable();
            $table->string('status')->default(\App\Utils\Enums\BusinessStatusEnum::ACTIVE->value); //1- Active, 0 - Disabled, 2 - Inactive
            $table->decimal('balance', 12, 2)->default(0); //Earning from referral and VAS
            $table->timestamp('last_seen')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('businesses', function (Blueprint $table) {
            $table->foreign('referral_business_code', 'parent_business_fk')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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

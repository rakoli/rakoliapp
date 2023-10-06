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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('country_code')->nullable();
            $table->string('business_code')->nullable();
            $table->foreign('business_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('current_location_code')->nullable();
            $table->string('type')->default("agent");
            $table->string('code')->nullable()->unique();
            $table->string('name');
            $table->string('phone_otp')->nullable();
            $table->string('email_otp')->nullable();
            $table->string('phone');
            $table->string('email')->nullable()->unique();
            $table->string('isVerified')->nullable();
            $table->string("AuthToken")->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_super_agent')->default(false);

            $table->timestamp('last_login')->nullable();
            $table->integer('status')->default(1);
            $table->boolean('should_change_password')->default(false);

            $table->string('iddoc_type')->nullable();
            $table->string('iddoc_id')->nullable()->unique();
            $table->string('iddoc_path')->nullable();

            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

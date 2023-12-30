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
            $table->string('country_code');
            $table->foreign('country_code')->references('code')
                ->on('countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('business_code')->nullable();
            $table->foreign('business_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('type');
            $table->string('code')->nullable()->unique();
            $table->string('fname');
            $table->string('lname');
            $table->string('phone')->index();
            $table->string('email')->nullable()->unique();
            $table->boolean('is_super_agent')->default(false);
            $table->integer('status')->default(\App\Utils\Enums\UserStatusEnum::ACTIVE);
            $table->integer('registration_step')->default(1);
            $table->timestamp('last_login')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('id_verified_at')->nullable();
            $table->boolean('should_change_password')->default(false);

            $table->string('phone_otp')->nullable();
            $table->timestamp('phone_otp_time')->nullable();
            $table->integer('phone_otp_count')->nullable();

            $table->string('email_otp')->nullable();
            $table->timestamp('email_otp_time')->nullable();
            $table->integer('email_otp_count')->nullable();


            $table->string('iddoc_type')->nullable();
            $table->string('iddoc_id')->nullable()->unique();
            $table->string('iddoc_path')->nullable();
            $table->boolean('iddoc_verified')->default(0);


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

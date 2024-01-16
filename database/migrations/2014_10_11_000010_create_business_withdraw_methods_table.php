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
        Schema::create('business_withdraw_methods', function (Blueprint $table) {
            $table->id();
            $table->string('business_code');
            $table->foreign('business_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('requesting_user_code');
            $table->foreign('requesting_user_code')->references('code')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('amount_currency');
            $table->string('method_name');
            $table->string('method_ac_name');
            $table->string('method_ac_number');
            $table->string('status')->default(\App\Utils\Enums\BusinessWithdrawMethodStatusEnum::REQUESTED->value);//requested,approved,complete
            $table->timestamps();

            $table->unique(['requesting_user_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_withdraw_methods');
    }
};

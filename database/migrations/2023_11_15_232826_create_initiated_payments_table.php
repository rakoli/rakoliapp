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
        Schema::create('initiated_payments', function (Blueprint $table) {
            $table->id();
            $table->string('country_code');
            $table->foreign('country_code')->references('code')
                ->on('countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('business_code');
            $table->foreign('business_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('code')->unique();
            $table->string('channel');
            $table->string('income_category');//\App\Utils\Enums\SystemIncomeCategoryEnum::class
            $table->string('description');
            $table->decimal('amount', 12,2)->default('0.00');
            $table->string('amount_currency');
            $table->timestamp('expiry_time');
            $table->string('pay_code')->nullable();//Reference needed to pay
            $table->string('pay_url')->nullable();//Reference needed to pay
            $table->string('status')->default(\App\Utils\Enums\InitiatedPaymentStatusEnum::INITIATED);
            $table->string('channel_ref_name');
            $table->string('channel_ref');
            $table->text('data')->invisible()->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('initiated_payments');
    }
};

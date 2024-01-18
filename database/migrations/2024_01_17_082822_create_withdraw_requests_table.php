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
        Schema::create('withdraw_requests', function (Blueprint $table) {
            $table->id();
            $table->string('business_code');
            $table->foreign('business_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('method_name');
            $table->string('method_ac_name');
            $table->string('method_ac_number');
            $table->decimal('amount', 12,2)->default('0.00');
            $table->string('amount_currency');
            $table->string('status')->default(\App\Utils\Enums\WithdrawMethodStatusEnum::REQUESTED->value);//requested, processing, completed
            $table->string('completion_reference')->nullable();
            $table->text('completion_note')->nullable();
            $table->timestamp('completion_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraw_requests');
    }
};

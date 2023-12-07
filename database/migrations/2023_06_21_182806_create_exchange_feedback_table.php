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
        Schema::create('exchange_feedback', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('exchange_trnx_id')->unsigned();
            $table->foreign('exchange_trnx_id')->references('id')
                ->on('exchange_transactions')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('reviewed_business_code');
            $table->foreign('reviewed_business_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->boolean('review');
            $table->string('review_comment')->nullable();

            $table->string('reviewer_user_code');
            $table->foreign('reviewer_user_code')->references('code')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_feedback');
    }
};

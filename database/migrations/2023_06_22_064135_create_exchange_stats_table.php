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
        Schema::create('exchange_stats', function (Blueprint $table) {
            $table->id();

            $table->string('business_code');
            $table->foreign('business_code')->references('code')
                ->on('businesses')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->integer('no_of_trades_completed')->default(0);
            $table->integer('no_of_trades_cancelled')->default(0);
            $table->integer('no_of_positive_feedback')->default(0);
            $table->integer('no_of_negative_feedback')->default(0);
            $table->decimal('volume_traded',12,2)->default(0);

            $table->decimal('completion',12,2)->default(0);
            $table->decimal('feedback',12,2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_stats');
    }
};

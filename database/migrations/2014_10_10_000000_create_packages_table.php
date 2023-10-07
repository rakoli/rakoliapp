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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('country_code');
            $table->foreign('country_code')->references('code')
                ->on('countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->string('code')->unique();
            $table->decimal('price', 12,2)->default('0.00');
            $table->integer('trial_period_hours')->unsigned()->default(0);
            $table->integer('package_interval_hours')->unsigned()->default(0);
            $table->integer('grace_period_hours')->unsigned()->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};

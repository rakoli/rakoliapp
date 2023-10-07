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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('business_code');
            $table->foreign('business_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('code')->unique();
            $table->string('name')->index();
            $table->decimal('cash_balance',12,2)->default(0);

            $table->string('region_code')->nullable();
            $table->foreign('region_code')->references('code')
                ->on('regions')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('town_code')->nullable();
            $table->foreign('town_code')->references('code')
                ->on('towns')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('area_code')->nullable();
            $table->foreign('area_code')->references('code')
                ->on('areas')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('pic')->nullable();
            $table->string('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};

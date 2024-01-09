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
        Schema::create('business_roles', function (Blueprint $table) {
            $table->id();
            $table->string('business_code');
            $table->foreign('business_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('code')->unique();
            $table->string('name')->index();
            $table->string('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_roles');
    }
};

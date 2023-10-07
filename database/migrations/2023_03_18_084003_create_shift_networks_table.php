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
        Schema::create('shift_networks', function (Blueprint $table) {
            $table->id();

            $table->string('business_code');
            $table->foreign('business_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('location_code');
            $table->foreign('location_code')->references('code')
                ->on('locations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignIdFor(\App\Models\Shift::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('network_code');
            $table->foreign('network_code')->references('code')
                ->on('networks')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->decimal('balance_old' , 12, 2)->default(0);
            $table->decimal('balance_new' , 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_networks');
    }
};

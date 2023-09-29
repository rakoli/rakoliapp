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
            $table->foreign('business_code')->references('Business_Code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('code')->unique();
            $table->string('name');
            $table->decimal('cash_balance',12,2)->default(0);
            $table->string('region')->nullable(); // fk
            $table->string('town')->nullable(); // fk
            $table->string('area')->nullable();
            $table->string('pic')->nullable();
           // $table->string('address')->virtualAs()
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

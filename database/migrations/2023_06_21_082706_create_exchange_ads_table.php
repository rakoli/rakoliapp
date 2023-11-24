<?php

use App\Utils\Enums\ExchangeStatusEnum;
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
        Schema::create('exchange_ads', function (Blueprint $table) {
            $table->id();

            $table->string('country_code');
            $table->foreign('country_code')->references('code')
                ->on('countries')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

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

            $table->string('code')->unique();

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

            $table->decimal('min_amount', 12,2);
            $table->decimal('max_amount', 12,2);
            $table->string('currency');
            $table->string('status')->default(ExchangeStatusEnum::ACTIVE->value);
            $table->string('description');
            $table->text('terms')->nullable();
            $table->string('availability_desc');
            $table->text('open_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_ads');
    }
};

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
        Schema::create('vas_tasks', function (Blueprint $table) {
            $table->id();

            $table->string('country_code');
            $table->foreign('country_code')->references('code')
                ->on('countries')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('vas_business_code')->nullable(); // vas provider
            $table->foreign('vas_business_code')->references('code')
                ->on('businesses')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('code')->unique();

            $table->dateTime('time_start');
            $table->dateTime('time_end')->nullable();

            $table->string('description');
            $table->text('note')->nullable()->invisible();

            $table->string('task_type')->default(\App\Utils\Enums\TaskTypeEnum::DATA->value);

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

            $table->boolean('is_public')->default(1); //
            $table->integer('no_of_agents')->nullable();
            $table->json('attachments')->invisible()->nullable();

            $table->string('status')->default(\App\Utils\Enums\VasTaskStatusEnum::ACTIVE->value);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vas_tasks');
    }
};

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
        Schema::create('vas_contracts', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->string('country_code');
            $table->foreign('country_code')
                ->references('code')
                ->on('countries')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('vas_provider_code'); // vas provider
            $table->foreign('vas_provider_code')->references('Business_Code')
                ->on('businesses')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('agent_code');
            $table->foreign('agent_code')->references('Business_Code')
                ->on('businesses')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('vas_task_code');
            $table->foreign('vas_task_code')->references('code')
                ->on('vas_tasks')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->dateTime('time_start');
            $table->dateTime('time_end')->nullable();


            $table->text('notes')->nullable()->invisible();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vas_contracts');
    }
};

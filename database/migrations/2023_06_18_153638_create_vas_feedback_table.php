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
        Schema::create('vas_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('country_code')->nullable();
            $table->foreign('country_code')->references('code')
                ->on('countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('agent_business_code')->nullable(); // agency
            $table->foreign('agent_business_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('vas_business_code')->nullable(); // vas provider
            $table->foreign('vas_business_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            $table->string('vas_task_code')->nullable();
            $table->foreign('vas_task_code')->references('code')
                ->on('vas_tasks')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('vas_contract_code')->nullable();
            $table->foreign('vas_contract_code')->references('code')
                ->on('vas_contracts')
                ->onDelete('cascade')
                ->onUpdate('cascade');



            $table->decimal('rating_agent',12,2);
            $table->decimal('rating_vas_provider',12,2);

            $table->text('comment_agent')->invisible()->nullable();
            $table->text('comment_vas_provider')->invisible()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vas_feedback');
    }
};

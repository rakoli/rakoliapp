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
        Schema::create('vas_contract_resources', function (Blueprint $table) {
            $table->id();

            $table->string('vas_contract_code')->nullable();
            $table->foreign('vas_contract_code')->references('code')
                ->on('vas_contracts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('notes')->nullable();

            $table->json('attachments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vas_contract_resources');
    }
};

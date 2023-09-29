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
        Schema::create('vas_payments', function (Blueprint $table) {
            $table->id();

            $table->string('vas_contract_code')->nullable();
            $table->foreign('vas_contract_code')->references('code')
                ->on('vas_contracts')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('initiator_code')->nullable(); // vas provider
            $table->foreign('initiator_code')->references('code')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('currency');
            $table->decimal('amount', 12, 2);

            $table->string('payment_method');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vas_payments');
    }
};

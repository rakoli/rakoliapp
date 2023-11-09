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

            $table->string('business_code');
            $table->foreign('business_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('vas_contract_code')->nullable();
            $table->foreign('vas_contract_code')->references('code')
                ->on('vas_contracts')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('initiator_user_code')->nullable(); // vas provider intiating user
            $table->foreign('initiator_user_code')->references('code')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('payee_business_code')->nullable(); // agent business
            $table->foreign('payee_business_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('code')->unique();

            $table->string('amount_currency');
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

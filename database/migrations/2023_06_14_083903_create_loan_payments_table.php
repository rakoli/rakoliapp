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
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->id();
            $table->string('loan_code');
            $table->foreign('loan_code')->references('code')
                ->on('loans')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('user_code');
            $table->foreign('user_code')->references('code')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('network_code')->nullable();
            $table->foreign('network_code')->references('code')
                ->on('networks')
                ->onDelete('cascade')
                ->onUpdate('cascade');
    

            $table->decimal('amount', 12, 2);

            $table->string('description')->nullable();

            $table->text('notes')->invisible()->nullable();

            $table->date('deposited_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_payments');
    }
};

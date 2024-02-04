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
        Schema::create('business_account_transactions', function (Blueprint $table) {
            $table->id();

            $table->string('business_code');
            $table->foreign('business_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('type');// enum <TransactionTypeEnum<Money_in, Money_out>>
            $table->string('category');// enum <TransactionCategoryEnum<Income, Expense, General>>
            $table->decimal('amount' , 12, 2);
            $table->string('amount_currency');
            $table->decimal('balance_old' , 12, 2)->default(0);
            $table->decimal('balance_new' , 12, 2)->default(0);
            $table->string('description');
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_account_transactions');
    }
};

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
        Schema::create('shift_transactions', function (Blueprint $table) {
            $table->id();

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

            $table->foreignIdFor(\App\Models\Shift::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('network_code');
            $table->foreign('network_code')->references('code')
                ->on('networks')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('user_code');
            $table->foreign('user_code')->references('code')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('code')->unique();
            $table->string('type'); // enum <TransactionTypeEnum<Money_in, Money_out>>
            $table->string('category'); // enum <TransactionCategoryEnum<Income, Expense, General>>
            $table->decimal('amount', 12, 2);
            $table->string('amount_currency');
            $table->decimal('balance_old', 12, 2);
            $table->decimal('balance_new', 12, 2);
            $table->decimal('crypto', 20, 10)->nullable();
            $table->decimal('exchange_rate', 20, 10)->nullable();
            $table->decimal('fee', 12, 2)->default(0);
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
        Schema::dropIfExists('shift_transactions');
    }
};

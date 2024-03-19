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
        Schema::create('shift_cash_transactions', function (Blueprint $table) {
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

            $table->string('user_code');
            $table->foreign('user_code')->references('code')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('code')->unique();
            $table->string('type'); // enum <TransactionTypeEnum<Money_in, Money_out>>
            $table->decimal('amount', 12, 2);
            $table->string('amount_currency');
            $table->decimal('balance_old', 12, 2);
            $table->decimal('balance_new', 12, 2);
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
        Schema::dropIfExists('shift_cash_transactions');
    }
};

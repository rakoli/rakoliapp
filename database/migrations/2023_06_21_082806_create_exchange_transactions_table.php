<?php

use App\Utils\Enums\ExchangeTransactionStatusEnum;
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
        Schema::create('exchange_transactions', function (Blueprint $table) {
            $table->id();

            $table->string('exchange_ads_code');
            $table->foreign('exchange_ads_code')->references('code')
                ->on('exchange_ads')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('owner_business_code');
            $table->foreign('owner_business_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('trader_business_code');
            $table->foreign('trader_business_code')->references('code')
                ->on('businesses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('trader_action_type');//\App\Utils\Enums\ExchangeTransactionTypeEnum::class
            $table->string('trader_target_method');
            $table->string('trader_action_via_method');
            $table->bigInteger('trader_action_via_method_id')->unsigned();
            $table->foreign('trader_action_via_method_id', 'method_id_fk')->references('id')
                ->on('exchange_payment_methods')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->decimal('amount',12,2);
            $table->string('amount_currency');
            $table->string('status')->default(ExchangeTransactionStatusEnum::OPEN);
            $table->boolean('is_complete')->default(false);
            $table->boolean('owner_submitted_feedback')->default(false);
            $table->boolean('trader_submitted_feedback')->default(false);

            $table->timestamp('owner_confirm_at')->nullable();
            $table->string('owner_confirm_by_user_code')->nullable();
            $table->foreign('owner_confirm_by_user_code')->references('code')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamp('trader_confirm_at')->nullable();
            $table->string('trader_confirm_by_user_code')->nullable();
            $table->foreign('trader_confirm_by_user_code')->references('code')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancelled_by_user_code')->nullable();
            $table->foreign('cancelled_by_user_code')->references('code')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->text('trader_comments')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_transactions');
    }
};

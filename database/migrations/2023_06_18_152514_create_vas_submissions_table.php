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
        Schema::create('vas_submissions', function (Blueprint $table) {
            $table->id();

            $table->string('vas_contract_code');
            $table->foreign('vas_contract_code')->references('code')
                ->on('vas_contracts')
                ->onDelete('cascade')
                ->onUpdate('cascade');



            $table->string('submitter_user_code');
            $table->foreign('submitter_user_code')->references('code')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('reviewer_user_code')->nullable();
            $table->foreign('reviewer_user_code')->references('code')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->dateTime('reviewed_at')->nullable();

            $table->string('status')->default(\App\Utils\Enums\TaskSubmissionStatusEnum::PENDING->value);

            $table->json('attachments')->invisible()->nullable();
            $table->string('description')->nullable();
            $table->text('notes')->nullable()->invisible();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vas_submissions');
    }
};

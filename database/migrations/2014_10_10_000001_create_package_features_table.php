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
        Schema::create('package_features', function (Blueprint $table) {
            $table->id();
            $table->string('package_code');
            $table->foreign('package_code')->references('code')
                ->on('packages')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('feature_code');
            $table->foreign('feature_code')->references('code')
                ->on('package_available_features')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('access')->nullable();
            $table->string('feature_value')->nullable();
            $table->boolean('available')->default(0);
            $table->text('description')->nullable();
            $table->mediumInteger('sort_order')->unsigned()->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_features');
    }
};

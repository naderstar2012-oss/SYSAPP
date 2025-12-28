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
        Schema::create('treasury', function (Blueprint $table) {
            $table->id();
            $table->enum('transactionType', ["deposit", "withdrawal"]);
            $table->integer('amount');
            $table->timestamp('transactionDate');
            $table->enum('category', ["rent_payment", "sale_payment", "expense", "purchase", "other"]);
            $table->string('referenceType', 50)->nullable();
            $table->unsignedBigInteger('referenceId')->nullable();
            $table->text('description');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('createdBy');
            $table->timestamp('createdAt')->useCurrent();

            $table->foreign('createdBy')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treasury');
    }
};

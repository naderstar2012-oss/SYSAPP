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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contractId');
            $table->string('invoiceNumber', 50)->unique();
            $table->integer('amount');
            $table->timestamp('dueDate');
            $table->enum('status', ['pending', 'paid', 'overdue', 'cancelled'])->default('pending');
            $table->timestamp('paidDate')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('createdBy');
            $table->timestamps();

            $table->foreign('contractId')->references('id')->on('contracts');
            $table->foreign('createdBy')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

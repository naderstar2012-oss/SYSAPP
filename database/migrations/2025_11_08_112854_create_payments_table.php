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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoiceId');
            $table->integer('amount');
            $table->timestamp('paymentDate');
            $table->string('paymentMethod', 50)->nullable();
            $table->text('receiptFileUrl')->nullable();
            $table->text('receiptFileKey')->nullable();
            $table->text('disbursementFileUrl')->nullable();
            $table->text('disbursementFileKey')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('createdBy');
            $table->timestamps();

            $table->foreign('invoiceId')->references('id')->on('invoices');
            $table->foreign('createdBy')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

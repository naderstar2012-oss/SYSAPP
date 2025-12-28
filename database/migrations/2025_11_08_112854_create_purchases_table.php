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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('propertyId')->nullable();
            $table->text('description');
            $table->integer('amount');
            $table->timestamp('purchaseDate');
            $table->enum('category', ["furniture", "equipment", "supplies", "renovation", "other"]);
            $table->string('supplier', 255)->nullable();
            $table->string('invoiceNumber', 100)->nullable();
            $table->text('receiptFileUrl')->nullable();
            $table->text('receiptFileKey')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('createdBy');
            $table->timestamps();

            $table->foreign('propertyId')->references('id')->on('properties');
            $table->foreign('createdBy')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};

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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('propertyId');
            $table->unsignedBigInteger('tenantId');
            $table->enum('contractType', ['rent', 'sale'])->default('rent');
            $table->string('contractNumber', 50)->unique();
            $table->text('contractFileUrl')->nullable();
            $table->text('contractFileKey')->nullable();
            $table->timestamp('startDate');
            $table->timestamp('endDate');
            $table->integer('rentAmount');
            $table->integer('salePrice')->nullable();
            $table->enum('paymentType', ['monthly', 'quarterly', 'semi_annual', 'full']);
            $table->enum('rentSystem', ['monthly', 'annual'])->nullable();
            $table->integer('deposit')->nullable();
            $table->enum('status', ['active', 'expired', 'terminated', 'completed'])->default('active');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('createdBy');
            $table->timestamps();

            $table->foreign('propertyId')->references('id')->on('properties');
            $table->foreign('tenantId')->references('id')->on('tenants');
            $table->foreign('createdBy')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};

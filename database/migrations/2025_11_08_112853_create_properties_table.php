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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->enum('type', ['residential', 'commercial']);
            $table->unsignedBigInteger('countryId');
            $table->string('city', 100);
            $table->text('address');
            $table->text('description')->nullable();
            $table->integer('area')->nullable();
            $table->integer('rooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('floor')->nullable();
            $table->enum('status', ['available', 'rented', 'sold', 'maintenance'])->default('available');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('createdBy');
            $table->timestamps();

            $table->foreign('countryId')->references('id')->on('countries');
            $table->foreign('createdBy')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};

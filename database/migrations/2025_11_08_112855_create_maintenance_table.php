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
        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('propertyId');
            $table->string('title', 255);
            $table->text('description');
            $table->enum('type', ["repair", "cleaning", "inspection", "upgrade", "other"]);
            $table->enum('priority', ["low", "medium", "high", "urgent"])->default('medium');
            $table->enum('status', ["pending", "in_progress", "completed", "cancelled"])->default('pending');
            $table->integer('cost')->nullable();
            $table->timestamp('scheduledDate')->nullable();
            $table->timestamp('completedDate')->nullable();
            $table->string('contractor', 255)->nullable();
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
        Schema::dropIfExists('maintenance');
    }
};

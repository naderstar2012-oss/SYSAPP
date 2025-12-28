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
        Schema::create('notification_log', function (Blueprint $table) {
            $table->id();
            $table->text('recipient');
            $table->enum('type', ["email", "sms"]);
            $table->enum('status', ["sent", "failed"]);
            $table->text('subject')->nullable();
            $table->text('message')->nullable();
            $table->timestamp('sentAt')->useCurrent();
            $table->text('errorMessage')->nullable();
            $table->string('referenceType', 50)->nullable();
            $table->unsignedBigInteger('referenceId')->nullable();
            $table->unsignedBigInteger('createdBy');
            $table->timestamps();

            $table->foreign('createdBy')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_log');
    }
};

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
        Schema::create('email_settings', function (Blueprint $table) {
            $table->id();
            $table->string('smtpHost', 255);
            $table->integer('smtpPort');
            $table->string('smtpUser', 255);
            $table->text('smtpPassword'); // مشفر
            $table->string('fromName', 255);
            $table->boolean('isActive')->default(true);
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
        Schema::dropIfExists('email_settings');
    }
};

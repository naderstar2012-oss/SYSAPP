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
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId')->unique();
            $table->boolean('emailEnabled')->default(true);
            $table->boolean('emailContractExpiry')->default(true);
            $table->boolean('emailPaymentOverdue')->default(true);
            $table->boolean('emailPaymentReminder')->default(true);
            $table->boolean('emailMaintenance')->default(true);
            $table->boolean('smsEnabled')->default(false);
            $table->boolean('smsContractExpiry')->default(false);
            $table->boolean('smsPaymentOverdue')->default(false);
            $table->boolean('smsPaymentReminder')->default(false);
            $table->boolean('smsMaintenance')->default(false);
            $table->string('phoneNumber', 20)->nullable();
            $table->timestamps();

            $table->foreign('userId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};

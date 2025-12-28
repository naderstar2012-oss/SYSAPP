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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->string('title', 255);
            $table->text('message');
            $table->enum('type', ["payment_due", "contract_expiring", "contract_expired", "payment_overdue", "payment_reminder", "maintenance_scheduled", "invoice_paid", "general"]);
            $table->boolean('isRead')->default(false);
            $table->string('referenceType', 50)->nullable();
            $table->unsignedBigInteger('referenceId')->nullable();
            $table->timestamp('createdAt')->useCurrent();

            $table->foreign('userId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

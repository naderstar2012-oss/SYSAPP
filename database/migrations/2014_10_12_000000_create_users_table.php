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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('openId', 64)->unique();
            $table->text('name')->nullable();
            $table->string('email', 320)->nullable();
            $table->string('loginMethod', 64)->nullable();
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->timestamp('lastSignedIn')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

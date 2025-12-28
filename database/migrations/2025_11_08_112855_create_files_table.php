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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('fileName', 255);
            $table->text('fileUrl');
            $table->text('fileKey');
            $table->integer('fileSize');
            $table->enum('fileType', ["image", "document", "other"])->default('other');
            $table->enum('referenceType', ["property", "contract", "expense", "purchase", "other"])->default('other');
            $table->unsignedBigInteger('referenceId')->nullable();
            $table->unsignedBigInteger('createdBy');
            $table->timestamp('createdAt')->useCurrent();

            $table->foreign('createdBy')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};

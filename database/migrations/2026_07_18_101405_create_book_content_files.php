<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_content_files', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('file_type', 20); // zip, pdf, video
            $table->string('file_path', 255)->nullable();
            $table->string('extract_path', 255)->nullable();
            $table->string('entry_file', 255)->nullable(); // index.html
            $table->string('file_url', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->foreignId('book_id')->nullable()->constrained('books')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('content_id')->nullable()->constrained('contents')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_content_files');
    }
};

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
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->text('description');
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('section_id')->constrained('sections')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('type', ['assignment', 'assessment', 'coding lab']);
            $table->date('date');
            $table->time('start_time');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};

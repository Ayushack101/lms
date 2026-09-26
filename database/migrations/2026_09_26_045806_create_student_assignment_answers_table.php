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
        Schema::create('student_assignment_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_assignment_attempt_id')->constrained('student_assignment_attempts')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('question_id')->constrained('assignment_questions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('answer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_assignment_answers');
    }
};

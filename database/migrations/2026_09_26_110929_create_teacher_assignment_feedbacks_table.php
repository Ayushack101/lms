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
        Schema::create('teacher_assignment_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('student_assignment_attempts')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('question_id')->nullable()->constrained('assignment_questions')->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_assignment_feedbacks');
    }
};

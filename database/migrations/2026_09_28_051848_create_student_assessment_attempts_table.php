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
        Schema::create('student_assessment_attempts', function (Blueprint $table) {
            $table->id();
            $table->integer('total_marks')->nullable();
            $table->integer('obtained_marks')->nullable();
            $table->foreignId('student_id')->constrained('students')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('assessment_id')->constrained('teacher_assessments')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('test_template_id')->constrained('test_templates')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('is_submitted', ['pending', 'submitted'])->default('pending');
            $table->enum('is_teacher_checked',['pending','checked'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_assessment_attempts');
    }
};

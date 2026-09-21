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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_name', 255);
            $table->string('student_mobile', 10)->unique();
            $table->text('address')->nullable();
            $table->string('school_name', 255)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('class_id')->nullable()->constrained('classes')->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('section_id')->nullable()->constrained('sections')->onDelete('set null')->onUpdate('cascade');
            $table->string('teacher_code', 255);
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->onDelete('set null')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

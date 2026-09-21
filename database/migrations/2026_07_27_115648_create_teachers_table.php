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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_name', 255);
            $table->string('teacher_mobile', 10)->unique();
            $table->string('school_name', 255);
            $table->string('teacher_code');
            $table->text('school_address');
            $table->text('personal_address')->nullable();
            $table->string('principal_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('session_start', 255);
            $table->string('representative_name', 255)->nullable();
            $table->string('representative_contact', 10)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->foreignId('board_id')->nullable()->constrained('boards')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id', 'fk_quiz_attempts_user_id')->cascadeOnDelete();
            $table->foreignId('quiz_id')->constrained('quizzes', 'id', 'fk_quiz_attempts_quiz_id')->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained('lessons', 'id', 'fk_quiz_attempts_lesson_id')->cascadeOnDelete();

            // null = belum bisa dikoreksi otomatis (mis. essay bebas lama)
            $table->boolean('is_correct')->nullable();

            $table->unsignedInteger('xp_earned')->default(0);

            $table->unsignedInteger('attempt_count')->default(1);
            $table->timestamp('answered_at')->nullable();
            $table->timestamps();

            // Satu baris per siswa per soal — jawaban terbaru menimpa (upsert).
            $table->unique(['user_id', 'quiz_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};

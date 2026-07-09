<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Buat tabel user_progress terlebih dahulu
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id', 'fk_user_progress_user_id')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses', 'id', 'fk_user_progress_course_id')->cascadeOnDelete();
            $table->foreignId('lesson_id')->nullable()->constrained('lessons', 'id', 'fk_user_progress_lesson_id')->cascadeOnDelete();
            $table->enum('status', ['not_started', 'in_progress', 'completed'])->default('not_started');
            $table->integer('score')->nullable();
            $table->integer('xp_earned')->default(0);
            $table->integer('attempts')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        // Tambahkan kolom tambahan dari alter table sebelumnya
        Schema::table('user_progress', function (Blueprint $table) {
            $table->unsignedInteger('time_spent_minutes')->default(0)->after('attempts');
            $table->timestamp('last_accessed_at')->nullable()->after('time_spent_minutes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->index()->constrained('lessons', 'id', 'fk_quizzes_lesson_id')->cascadeOnDelete();
            $table->string('question');
            $table->enum('question_type', [
                'multiple_choice', 'fill_blank', 'matching',
                'ordering', 'typing', 'short_answer', 'essay', 'word_arrange',
            ])->default('multiple_choice')->index();
            $table->json('options')->nullable();
            $table->text('correct_answer');
            $table->text('explanation')->nullable();
            $table->unsignedInteger('xp_reward')->default(10);
            $table->unsignedInteger('time_limit_seconds')->default(30);
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};

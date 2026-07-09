<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->index()->constrained('courses', 'id', 'fk_lessons_course_id')->cascadeOnDelete();
            $table->string('slug')->unique()->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('objectives')->nullable();
            $table->enum('lesson_type', ['vocabulary', 'quiz', 'reading', 'exercise', 'video'])->default('vocabulary')->index();
            $table->unsignedInteger('duration_minutes')->default(0);
            $table->unsignedInteger('xp_reward')->default(0);
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->longText('content')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
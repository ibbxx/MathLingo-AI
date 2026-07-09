<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id', 'fk_student_profiles_user_id')->cascadeOnDelete();
            $table->enum('educational_level', ['junior_high', 'senior_high', 'undergraduate', 'teacher'])->default('senior_high');
            $table->enum('learning_goal', ['vocabulary', 'problem_solving', 'olympiad', 'international_exams'])->default('vocabulary');
            $table->integer('xp_total')->default(0);
            $table->integer('xp_today')->default(0);
            $table->integer('streak_days')->default(0);
            $table->date('streak_last_activity')->nullable();
            $table->enum('league', ['bronze', 'silver', 'gold', 'platinum', 'diamond', 'obsidian'])->default('bronze');
            $table->integer('current_level')->default(1);
            $table->integer('gems')->default(0);
            $table->integer('hearts')->default(5);
            $table->integer('hearts_max')->default(5);
            $table->string('avatar_url', 500)->nullable();
            $table->text('bio')->nullable();
            $table->string('country', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('color', 20)->default('#4F46E5');
            $table->unsignedInteger('xp_reward')->default(0);
            $table->string('condition_type')->nullable();
            $table->unsignedInteger('condition_value')->default(0);
            $table->timestamps();
        });

        Schema::create('user_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained('users', 'id', 'fk_user_achievements_user_id')->cascadeOnDelete();
            $table->foreignId('achievement_id')->index()->constrained('achievements', 'id', 'fk_user_achievements_ach_id')->cascadeOnDelete();
            $table->timestamp('earned_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'achievement_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_achievements');
        Schema::dropIfExists('achievements');
    }
};
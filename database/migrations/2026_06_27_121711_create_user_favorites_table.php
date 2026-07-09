<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id', 'fk_user_favorites_user_id')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses', 'id', 'fk_user_favorites_course_id')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_favorites');
    }
};
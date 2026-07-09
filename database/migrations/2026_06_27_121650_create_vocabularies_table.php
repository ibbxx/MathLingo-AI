<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vocabularies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('lessons', 'id', 'fk_vocabularies_lesson_id')->cascadeOnDelete();
            $table->string('term');
            $table->text('mathematical_meaning')->nullable();
            $table->string('pronunciation')->nullable();
            $table->string('audio_path')->nullable();
            $table->text('example')->nullable();
            $table->text('example_sentence')->nullable();
            $table->string('translation')->nullable();
            $table->string('formula')->nullable();
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vocabularies');
    }
};
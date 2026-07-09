<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Buat tabel courses terlebih dahulu
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('short_description', 500)->nullable();
            $table->string('icon')->nullable();
            $table->string('color', 7)->default('#2563EB');
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->unsignedInteger('total_lessons')->default(0);
            $table->unsignedInteger('total_xp')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->integer('sort_order')->default(0)->index();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });

        // Tambahkan kolom tambahan (yang sebelumnya salah diletakkan sebagai modifikasi langsung)
        Schema::table('courses', function (Blueprint $table) {
            $table->string('category')->nullable()->after('color');
            $table->string('thumbnail')->nullable()->after('category');
            $table->boolean('is_featured')->default(false)->after('thumbnail');
            $table->unsignedInteger('estimated_minutes')->default(0)->after('total_xp');
            $table->string('language')->default('en')->after('estimated_minutes');
            $table->unsignedInteger('students_count')->default(0)->after('language');
            $table->decimal('rating', 3, 2)->default(0)->after('students_count');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
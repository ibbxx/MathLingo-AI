<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id', 'fk_certificates_user_id')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses', 'id', 'fk_certificates_course_id')->cascadeOnDelete();

            // Kode unik yang tercetak di sertifikat, mis. "MLA-2026-000123"
            $table->string('certificate_number')->unique();

            // Snapshot ringkas kondisi siswa saat sertifikat diterbitkan,
            // supaya kalau data lain berubah nanti, sertifikat tetap akurat.
            $table->unsignedInteger('total_lessons')->default(0);
            $table->unsignedInteger('total_xp_earned')->default(0);
            $table->unsignedTinyInteger('quiz_score_percent')->nullable();

            $table->timestamp('issued_at');
            $table->timestamps();

            // Satu siswa hanya bisa punya 1 sertifikat per kursus.
            $table->unique(['user_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};

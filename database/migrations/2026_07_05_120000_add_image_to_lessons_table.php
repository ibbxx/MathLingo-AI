<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            // Gambar sampul/ilustrasi pelajaran (opsional).
            // Path disimpan relatif terhadap disk "public" (storage/app/public/lesson-images/...).
            $table->string('image')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};

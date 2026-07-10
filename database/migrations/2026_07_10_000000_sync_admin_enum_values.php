<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        DB::statement("ALTER TABLE `quizzes` MODIFY `question_type` ENUM('multiple_choice','fill_blank','matching','ordering','typing','short_answer','essay','word_arrange') NOT NULL DEFAULT 'multiple_choice'");
        DB::statement("ALTER TABLE `lessons` MODIFY `lesson_type` ENUM('vocabulary','quiz','reading','exercise','video','grammar','practice') NOT NULL DEFAULT 'vocabulary'");
    }

    public function down(): void
    {
        if (! in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        DB::statement("ALTER TABLE `quizzes` MODIFY `question_type` ENUM('multiple_choice','fill_blank','matching','ordering','typing','short_answer','essay') NOT NULL DEFAULT 'multiple_choice'");
        DB::statement("ALTER TABLE `lessons` MODIFY `lesson_type` ENUM('vocabulary','quiz','reading','exercise','video') NOT NULL DEFAULT 'vocabulary'");
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('courses', 'category')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->string('category', 100)
                      ->default('General Mathematics')
                      ->after('description');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('courses', 'category')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }
    }
};
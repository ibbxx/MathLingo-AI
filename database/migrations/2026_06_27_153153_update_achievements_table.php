<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── 1. ALTER tabel achievements yang sudah ada secara aman ───────────
        Schema::table('achievements', function (Blueprint $table) {
            if (!Schema::hasColumn('achievements', 'slug')) {
                $table->string('slug')->unique()->after('id');
            }
            if (!Schema::hasColumn('achievements', 'category')) {
                $table->string('category', 100)->default('Learning')->after('description');
            }
            if (!Schema::hasColumn('achievements', 'icon')) {
                $table->string('icon', 100)->nullable()->after('title');
            }
            if (!Schema::hasColumn('achievements', 'color')) {
                $table->string('color', 7)->default('#2563EB')->after('icon');
            }
            if (!Schema::hasColumn('achievements', 'rarity')) {
                $table->string('rarity', 20)->default('common')->after('color');
            }
            if (!Schema::hasColumn('achievements', 'requirement_type')) {
                $table->string('requirement_type', 100)->nullable()->after('rarity');
            }
            if (!Schema::hasColumn('achievements', 'requirement_value')) {
                $table->integer('requirement_value')->default(1)->after('requirement_type');
            }
            if (!Schema::hasColumn('achievements', 'is_hidden')) {
                $table->boolean('is_hidden')->default(false)->after('requirement_value');
            }
            if (!Schema::hasColumn('achievements', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('is_hidden');
            }
        });

        // ── 2. Buat tabel user_achievements BARU jika belum ada secara aman ─────
        if (!Schema::hasTable('user_achievements')) {
            Schema::create('user_achievements', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users', 'id', 'fk_user_achievements_user_id_alt')->cascadeOnDelete();
                $table->foreignId('achievement_id')->constrained('achievements', 'id', 'fk_user_achievements_ach_id_alt')->cascadeOnDelete();
                $table->timestamp('earned_at')->useCurrent();
                $table->timestamps();

                $table->unique(['user_id', 'achievement_id'], 'user_achievement_unique_alt');
                $table->index('user_id', 'user_achievements_user_id_idx_alt');
                $table->index('achievement_id', 'user_achievements_achievement_id_idx_alt');
            });
        }
    }

    public function down(): void
    {
        Schema::table('achievements', function (Blueprint $table) {
            if (Schema::hasColumn('achievements', 'slug')) {
                $table->dropUnique(['slug']);
                $table->dropColumn('slug');
            }
            if (Schema::hasColumn('achievements', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('achievements', 'icon')) {
                $table->dropColumn('icon');
            }
            if (Schema::hasColumn('achievements', 'color')) {
                $table->dropColumn('color');
            }
            if (Schema::hasColumn('achievements', 'rarity')) {
                $table->dropColumn('rarity');
            }
            if (Schema::hasColumn('achievements', 'requirement_type')) {
                $table->dropColumn('requirement_type');
            }
            if (Schema::hasColumn('achievements', 'requirement_value')) {
                $table->dropColumn('requirement_value');
            }
            if (Schema::hasColumn('achievements', 'is_hidden')) {
                $table->dropColumn('is_hidden');
            }
            if (Schema::hasColumn('achievements', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
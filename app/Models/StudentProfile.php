<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'educational_level',
        'learning_goal',
        'xp_total',
        'xp_today',
        'streak_days',
        'streak_last_activity',
        'league',
        'current_level',
        'gems',
        'hearts',
        'hearts_max',
        'avatar_url',
        'bio',
        'country',
    ];

    protected $casts = [
        'streak_last_activity' => 'date',
        'xp_total' => 'integer',
        'xp_today' => 'integer',
        'streak_days' => 'integer',
        'current_level' => 'integer',
        'gems' => 'integer',
        'hearts' => 'integer',
        'hearts_max' => 'integer',
    ];

    protected $attributes = [
        'current_level' => 1,
        'xp_total' => 0,
        'xp_today' => 0,
        'streak_days' => 0,
        'gems' => 0,
        'hearts' => 5,
        'hearts_max' => 5,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getLeagueLabelAttribute(): string
    {
        return match($this->league) {
            'bronze'   => 'Bronze League',
            'silver'   => 'Silver League',
            'gold'     => 'Gold League',
            'platinum' => 'Platinum League',
            'diamond'  => 'Diamond League',
            'obsidian' => 'Obsidian League',
            default    => 'Bronze League',
        };
    }

    public function getLeagueColorAttribute(): string
    {
        return match($this->league) {
            'bronze'   => '#CD7F32',
            'silver'   => '#C0C0C0',
            'gold'     => '#FFD700',
            'platinum' => '#E5E4E2',
            'diamond'  => '#B9F2FF',
            'obsidian' => '#1a1a2e',
            default    => '#CD7F32',
        };
    }

    public function getLeagueEmojiAttribute(): string
    {
        return match($this->league) {
            'bronze'   => '🥉',
            'silver'   => '🥈',
            'gold'     => '🥇',
            'platinum' => '💠',
            'diamond'  => '💎',
            'obsidian' => '🖤',
            default    => '🥉',
        };
    }

    public function getEducationalLevelLabelAttribute(): string
    {
        return match($this->educational_level) {
            'junior_high'    => 'Junior High School',
            'senior_high'    => 'Senior High School',
            'undergraduate'  => 'Undergraduate',
            'teacher'        => 'Teacher',
            default          => 'Senior High School',
        };
    }

    public function getLearningGoalLabelAttribute(): string
    {
        return match($this->learning_goal) {
            'vocabulary'        => 'Improve Mathematical Vocabulary',
            'problem_solving'   => 'Improve Problem Solving',
            'olympiad'          => 'Prepare for Olympiad',
            'international_exams' => 'Prepare for International Exams',
            default             => 'Improve Mathematical Vocabulary',
        };
    }

    public function getXpToNextLevelAttribute(): int
    {
        $level = $this->current_level ?: 1;
        return $level * 100;
    }

    public function getLevelProgressPercentAttribute(): int
    {
        $needed = $this->xp_to_next_level;
        if ($needed <= 0) {
            return 0;
        }
        $xpInCurrentLevel = $this->xp_total % $needed;
        return (int) round(($xpInCurrentLevel / $needed) * 100);
    }

    public function updateStreak(): void
    {
        $today = now()->toDateString();
        $lastActivity = $this->streak_last_activity?->toDateString();

        if ($lastActivity === $today) {
            return;
        }

        if ($lastActivity === now()->subDay()->toDateString()) {
            $this->streak_days++;
        } else {
            $this->streak_days = 1;
        }

        $this->streak_last_activity = $today;
        $this->save();
    }

    public function addXp(int $amount): void
    {
        $this->xp_total += $amount;
        $this->xp_today += $amount;

        $newLevel = (int) floor($this->xp_total / 100) + 1;
        if ($newLevel > $this->current_level) {
            $this->current_level = $newLevel;
        }

        $this->save();
    }
}
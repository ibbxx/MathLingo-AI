<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'category',
        'badge_icon',
        'icon',
        'color',
        'rarity',
        'requirement_type',
        'requirement_value',
        'xp_reward',
        'is_hidden',
        'is_active',
    ];

    protected $casts = [
        'requirement_value' => 'integer',
        'xp_reward'         => 'integer',
        'is_hidden'         => 'boolean',
        'is_active'         => 'boolean',
    ];

    // ── BOOT ────────────────────────────────────────────────────────────────
    protected static function booted(): void
    {
        static::creating(function (Achievement $achievement) {
            if (empty($achievement->slug)) {
                $achievement->slug = Str::slug($achievement->title);
            }
        });
    }

    // ── RELATIONS ───────────────────────────────────────────────────────────
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_achievements')
            ->withPivot('earned_at')
            ->withTimestamps();
    }

    // ── SCOPES ──────────────────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('is_hidden', false);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByRarity($query, string $rarity)
    {
        return $query->where('rarity', $rarity);
    }

    // ── ACCESSORS ───────────────────────────────────────────────────────────

    /**
     * Warna gradient berdasarkan rarity.
     */
    public function getGradientAttribute(): string
    {
        return match($this->rarity) {
            'legendary' => 'linear-gradient(135deg, #F59E0B 0%, #EF4444 100%)',
            'epic'      => 'linear-gradient(135deg, #8B5CF6 0%, #EC4899 100%)',
            'rare'      => 'linear-gradient(135deg, #2563EB 0%, #06B6D4 100%)',
            default     => 'linear-gradient(135deg, #10B981 0%, #059669 100%)',
        };
    }

    /**
     * Label rarity dalam Bahasa Indonesia.
     */
    public function getRarityLabelAttribute(): string
    {
        return match($this->rarity) {
            'legendary' => 'Legendaris',
            'epic'      => 'Epik',
            'rare'      => 'Langka',
            default     => 'Umum',
        };
    }

    /**
     * Warna badge rarity.
     */
    public function getRarityColorAttribute(): string
    {
        return match($this->rarity) {
            'legendary' => '#F59E0B',
            'epic'      => '#8B5CF6',
            'rare'      => '#2563EB',
            default     => '#10B981',
        };
    }

    /**
     * Warna background badge rarity.
     */
    public function getRarityBgAttribute(): string
    {
        return match($this->rarity) {
            'legendary' => '#FFFBEB',
            'epic'      => '#F5F3FF',
            'rare'      => '#EFF6FF',
            default     => '#ECFDF5',
        };
    }

    /**
     * Label kategori yang rapi.
     */
    public function getCategoryLabelAttribute(): string
    {
        $map = [
            'Learning'            => 'Pembelajaran',
            'Vocabulary'          => 'Kosakata',
            'Quiz'                => 'Kuis',
            'Course Completion'   => 'Penyelesaian Kursus',
            'Daily Streak'        => 'Streak Harian',
            'Consistency'         => 'Konsistensi',
            'Reading'             => 'Membaca',
            'Grammar'             => 'Tata Bahasa',
            'Listening'           => 'Mendengarkan',
            'Research'            => 'Riset',
            'Mathematical English'=> 'Bahasa Inggris Matematik',
            'AI Tutor'            => 'AI Tutor',
            'Problem Solving'     => 'Pemecahan Masalah',
            'Speed'               => 'Kecepatan',
            'Master'              => 'Master',
        ];

        return $map[$this->category] ?? $this->category;
    }

    /**
     * Semua kategori yang tersedia.
     */
    public static function categories(): array
    {
        return [
            'Learning', 'Vocabulary', 'Quiz', 'Course Completion',
            'Daily Streak', 'Consistency', 'Reading', 'Grammar',
            'Listening', 'Research', 'Mathematical English',
            'AI Tutor', 'Problem Solving', 'Speed', 'Master',
        ];
    }

    /**
     * Semua rarity yang tersedia.
     */
    public static function rarities(): array
    {
        return ['common', 'rare', 'epic', 'legendary'];
    }
}
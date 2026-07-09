<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    // =========================================================
    // KOLOM DATABASE
    // id, slug, title, short_description, description, icon,
    // color, category, thumbnail, is_featured, difficulty,
    // total_lessons, total_xp, estimated_minutes, language,
    // students_count, rating, is_active, sort_order,
    // status (draft|published|archived), created_at, updated_at, deleted_at
    // =========================================================

    protected $fillable = [
        'slug',
        'title',
        'short_description',
        'description',
        'icon',
        'color',
        'category',
        'thumbnail',
        'difficulty',
        'total_lessons',
        'total_xp',
        'estimated_minutes',
        'language',
        'students_count',
        'rating',
        'is_active',
        'is_featured',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'is_active'         => 'boolean',
        'is_featured'       => 'boolean',
        'total_lessons'     => 'integer',
        'total_xp'          => 'integer',
        'sort_order'        => 'integer',
        'estimated_minutes' => 'integer',
        'students_count'    => 'integer',
        'rating'            => 'float',
    ];

    // =========================================================
    // BOOT — auto-slug
    // =========================================================

    protected static function booted(): void
    {
        static::creating(function (Course $course) {
            if (empty($course->slug)) {
                $course->slug = static::generateUniqueSlug($course->title);
            }
        });
    }

    public static function generateUniqueSlug(string $title, ?int $exceptId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i    = 1;

        while (
            static::withTrashed()
                ->where('slug', $slug)
                ->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))
                ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    // =========================================================
    // RELATIONSHIPS
    // =========================================================

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('sort_order');
    }

    public function activeLessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function progress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_favorites')->withTimestamps();
    }

    // =========================================================
    // SCOPES
    // =========================================================

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeForStudent(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    // =========================================================
    // ACCESSORS
    // =========================================================

    public function getDifficultyLabelAttribute(): string
    {
        return match ($this->difficulty) {
            'beginner'     => 'Beginner',
            'intermediate' => 'Intermediate',
            'advanced'     => 'Advanced',
            default        => 'Beginner',
        };
    }

    public function getDifficultyColorAttribute(): string
    {
        return match ($this->difficulty) {
            'beginner'     => '#22C55E',
            'intermediate' => '#F59E0B',
            'advanced'     => '#EF4444',
            default        => '#22C55E',
        };
    }

    public function getDifficultyBgAttribute(): string
    {
        return match ($this->difficulty) {
            'beginner'     => '#F0FDF4',
            'intermediate' => '#FFFBEB',
            'advanced'     => '#FEF2F2',
            default        => '#F0FDF4',
        };
    }

    public function getColorAttribute($value): string
    {
        return $value ?? '#2563EB';
    }

    public function getCategoryLabelAttribute(): string
    {
        return $this->category ?: 'General';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'published' => 'Published',
            'archived'  => 'Archived',
            default     => 'Draft',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'published' => '#22C55E',
            'archived'  => '#F59E0B',
            default     => '#64748B',
        };
    }

    public function getStatusBgAttribute(): string
    {
        return match ($this->status) {
            'published' => '#F0FDF4',
            'archived'  => '#FFFBEB',
            default     => '#F8FAFC',
        };
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if (! $this->thumbnail) {
            return null;
        }
        return asset('storage/' . $this->thumbnail);
    }

    public function getEstimatedDurationAttribute(): int
    {
        if ($this->relationLoaded('lessons')) {
            $sum = $this->lessons->sum('duration_minutes');
            return $sum > 0 ? (int) $sum : (int) ($this->estimated_minutes ?? 0);
        }
        return (int) ($this->estimated_minutes ?? 0);
    }

    public function getCalculatedProgressAttribute(): int
    {
        if (! $this->relationLoaded('progress')) {
            return 0;
        }

        $totalLessons = $this->lessons_count ?? $this->total_lessons ?? 0;

        if ($totalLessons === 0) {
            return 0;
        }

        $completed = $this->progress
            ->where('status', 'completed')
            ->whereNotNull('lesson_id')
            ->count();

        return (int) min(100, round(($completed / $totalLessons) * 100));
    }

    public function getProgressPercentAttribute(): int
    {
        return $this->calculated_progress;
    }

    public function getProgressStatusAttribute(): string
    {
        $pct = $this->calculated_progress;
        if ($pct === 0) return 'not_started';
        if ($pct >= 100) return 'completed';
        return 'in_progress';
    }

    public function getIsFavoritedAttribute(): bool
    {
        if (! $this->relationLoaded('favoritedByUsers')) {
            return false;
        }
        return $this->favoritedByUsers->contains('id', Auth::id());
    }

    public function getRemainingLessonsAttribute(): int
    {
        $total     = $this->lessons_count ?? $this->total_lessons ?? 0;
        $completed = 0;

        if ($this->relationLoaded('progress')) {
            $completed = $this->progress
                ->where('status', 'completed')
                ->whereNotNull('lesson_id')
                ->count();
        }

        return max(0, $total - $completed);
    }

    public function getRatingDisplayAttribute(): string
    {
        return $this->rating > 0 ? number_format($this->rating, 1) : '-';
    }

    // =========================================================
    // STATIC HELPERS
    // =========================================================

    public static function availableCategories(): array
    {
        return [
            'General Mathematics',
            'Algebra',
            'Geometry',
            'Calculus',
            'Statistics',
            'Number Theory',
            'Trigonometry',
            'Linear Algebra',
            'Discrete Mathematics',
            'Mathematical Logic',
        ];
    }
}
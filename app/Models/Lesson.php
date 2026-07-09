<?php

namespace App\Models;

use App\Support\PublicStorage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Lesson extends Model
{
    use HasFactory;

    // =========================================================
    // KOLOM DATABASE
    // id, course_id, slug, title, description, content,
    // lesson_type (enum: vocabulary|reading|grammar|practice|quiz),
    // xp_reward, duration_minutes, sort_order, is_active,
    // created_at, updated_at
    // =========================================================

    protected $fillable = [
        'course_id',
        'slug',
        'title',
        'description',
        'image',
        'content',
        'lesson_type',
        'xp_reward',
        'duration_minutes',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'duration_minutes' => 'integer',
        'xp_reward'        => 'integer',
        'sort_order'       => 'integer',
        'course_id'        => 'integer',
    ];

    // =========================================================
    // BOOT — auto-slug
    // =========================================================

    protected static function booted(): void
    {
        static::creating(function (Lesson $lesson) {
            if (empty($lesson->slug)) {
                $lesson->slug = static::generateUniqueSlug($lesson->title, $lesson->course_id);
            }
        });

        static::deleting(function (Lesson $lesson) {
            // Trigger child model cleanup before database cascade removes their rows.
            foreach ($lesson->vocabularies as $vocab) {
                $vocab->delete();
            }

            foreach ($lesson->quizzes as $quiz) {
                $quiz->delete();
            }

            if ($lesson->image) {
                PublicStorage::delete($lesson->image);
            }

            PublicStorage::deleteImagesFromHtml($lesson->content);
        });

        static::updated(function (Lesson $lesson) {
            if ($lesson->wasChanged('image') && $lesson->getOriginal('image')) {
                PublicStorage::delete($lesson->getOriginal('image'));
            }

            if ($lesson->wasChanged('content')) {
                $oldPaths = PublicStorage::imagePathsFromHtml($lesson->getOriginal('content'));
                $newPaths = PublicStorage::imagePathsFromHtml($lesson->content);

                foreach (array_diff($oldPaths, $newPaths) as $path) {
                    PublicStorage::delete($path);
                }
            }
        });
    }

    public static function generateUniqueSlug(string $title, int $courseId, ?int $exceptId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i    = 1;

        while (
            static::where('course_id', $courseId)
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

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function vocabularies(): HasMany
    {
        return $this->hasMany(Vocabulary::class)->orderBy('sort_order');
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class)->orderBy('sort_order');
    }

    public function userProgress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    // =========================================================
    // SCOPES
    // =========================================================

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('lesson_type', $type);
    }

    // =========================================================
    // ACCESSORS
    // =========================================================

    public function getImageUrlAttribute(): ?string
    {
        return PublicStorage::url($this->image);
    }

    public function getPublicContentAttribute(): string
    {
        return PublicStorage::rewritePublicUrls($this->content);
    }

    public function getLessonTypeLabelAttribute(): string
    {
        return match ($this->lesson_type) {
            'vocabulary' => 'Vocabulary',
            'reading'    => 'Reading',
            'grammar'    => 'Grammar',
            'practice'   => 'Practice',
            'quiz'       => 'Quiz',
            default      => ucfirst($this->lesson_type ?? 'Lesson'),
        };
    }

    public function getLessonTypeColorAttribute(): string
    {
        return match ($this->lesson_type) {
            'vocabulary' => '#2563EB',
            'reading'    => '#06B6D4',
            'grammar'    => '#8B5CF6',
            'practice'   => '#22C55E',
            'quiz'       => '#F59E0B',
            default      => '#6B7280',
        };
    }

    public function getLessonTypeBgAttribute(): string
    {
        return match ($this->lesson_type) {
            'vocabulary' => '#DBEAFE',
            'reading'    => '#ECFEFF',
            'grammar'    => '#EDE9FE',
            'practice'   => '#F0FDF4',
            'quiz'       => '#FFFBEB',
            default      => '#F3F4F6',
        };
    }

    public function getLessonTypeIconAttribute(): string
    {
        return match ($this->lesson_type) {
            'vocabulary' => '📖',
            'reading'    => '📝',
            'grammar'    => '✏️',
            'practice'   => '💪',
            'quiz'       => '🎯',
            default      => '📚',
        };
    }
}

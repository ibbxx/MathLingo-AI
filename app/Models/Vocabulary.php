<?php

namespace App\Models;

use App\Support\PublicStorage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vocabulary extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'term',
        'image',
        'mathematical_meaning',
        'pronunciation',
        'audio_path',
        'example',
        'example_sentence',
        'translation',
        'formula',
        'difficulty',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return PublicStorage::url($this->image);
    }

    public function getAudioUrlAttribute(): ?string
    {
        if (! $this->audio_path) {
            return null;
        }

        if (str_starts_with($this->audio_path, 'http://') || str_starts_with($this->audio_path, 'https://')) {
            return $this->audio_path;
        }

        return PublicStorage::url($this->audio_path);
    }
}

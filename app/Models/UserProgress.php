<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProgress extends Model
{
    use HasFactory;

    // =========================================================
    // KOLOM DATABASE (sesuai struktur tabel aktual di MySQL)
    // id, user_id, course_id, lesson_id, status, score,
    // xp_earned, attempts, completed_at,
    // created_at, updated_at
    //
    // CATATAN: time_spent_minutes dan last_accessed_at BELUM ada
    // di tabel karena migration-nya belum dijalankan.
    // Jika ingin menambah kolom tersebut, jalankan migration:
    // php artisan migrate
    // =========================================================

    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'course_id',
        'lesson_id',
        'status',
        'score',
        'xp_earned',
        'attempts',
        'completed_at',
    ];

    protected $casts = [
        'user_id'    => 'integer',
        'course_id'  => 'integer',
        'lesson_id'  => 'integer',
        'score'      => 'integer',
        'xp_earned'  => 'integer',
        'attempts'   => 'integer',
        'completed_at' => 'datetime',
    ];

    // =========================================================
    // RELATIONSHIPS
    // =========================================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    // =========================================================
    // HELPERS
    // =========================================================

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }
}
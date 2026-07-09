<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Rekaman jawaban 1 siswa untuk 1 soal quiz.
 * Satu baris per (user_id, quiz_id) — dijaga lewat unique constraint,
 * jadi tiap kali siswa menjawab ulang soal yang sama, baris ini di-upsert
 * (lihat StudentQuizController::checkAnswer()), bukan menambah baris baru.
 */
class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'lesson_id',
        'is_correct',
        'xp_earned',
        'attempt_count',
        'answered_at',
    ];

    protected $casts = [
        'is_correct'    => 'boolean',
        'xp_earned'     => 'integer',
        'attempt_count' => 'integer',
        'answered_at'   => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}

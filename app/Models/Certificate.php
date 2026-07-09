<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Sertifikat yang diterbitkan untuk 1 siswa setelah menyelesaikan 1 course
 * (semua lesson aktif di course tersebut berstatus 'completed').
 *
 * Diterbitkan otomatis dari CourseController::completeLesson() saat lesson
 * terakhir di sebuah course diselesaikan — lihat method issueForCompletedCourse().
 */
class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'certificate_number',
        'total_lessons',
        'total_xp_earned',
        'quiz_score_percent',
        'issued_at',
    ];

    protected $casts = [
        'total_lessons'      => 'integer',
        'total_xp_earned'    => 'integer',
        'quiz_score_percent' => 'integer',
        'issued_at'          => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Buat nomor sertifikat unik, format: MLA-{tahun}-{6 digit acak/incremental}.
     */
    public static function generateNumber(): string
    {
        do {
            $number = 'MLA-' . now()->format('Y') . '-' . strtoupper(Str::random(6));
        } while (static::where('certificate_number', $number)->exists());

        return $number;
    }

    /**
     * Terbitkan sertifikat untuk $user atas $course, kalau course tsb sudah
     * 100% selesai dan sertifikatnya belum pernah ada. Idempotent — aman
     * dipanggil berkali-kali (mis. tiap kali complete lesson).
     */
    public static function issueForCompletedCourse(User $user, Course $course): ?self
    {
        $existing = static::where('user_id', $user->id)->where('course_id', $course->id)->first();

        if ($existing) {
            return $existing;
        }

        $totalLessons = $course->activeLessons()->count();

        $completedLessons = UserProgress::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'completed')
            ->whereNotNull('lesson_id')
            ->count();

        if ($totalLessons === 0 || $completedLessons < $totalLessons) {
            return null; // belum selesai semua lesson-nya
        }

        $totalXp = (int) UserProgress::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->whereNotNull('lesson_id')
            ->sum('xp_earned');

        $quizIds = Quiz::whereIn('lesson_id', $course->activeLessons()->pluck('id'))->pluck('id');
        $attempts = QuizAttempt::where('user_id', $user->id)->whereIn('quiz_id', $quizIds)->get();
        $quizScore = $attempts->count() > 0
            ? (int) round(($attempts->where('is_correct', true)->count() / $attempts->count()) * 100)
            : null;

        return static::create([
            'user_id'            => $user->id,
            'course_id'          => $course->id,
            'certificate_number' => static::generateNumber(),
            'total_lessons'      => $totalLessons,
            'total_xp_earned'    => $totalXp,
            'quiz_score_percent' => $quizScore,
            'issued_at'          => now(),
        ]);
    }
}

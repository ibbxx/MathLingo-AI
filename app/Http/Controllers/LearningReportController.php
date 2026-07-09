<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\QuizAttempt;
use App\Models\StudentProfile;
use App\Models\UserProgress;
use App\Models\Vocabulary;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Laporan belajar (Learning Report) untuk siswa: ringkasan menyeluruh
 * progres belajar — per kursus, performa quiz, vocabulary, pencapaian,
 * dan sertifikat yang sudah didapat.
 */
class LearningReportController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $profile = $user->profile ?? StudentProfile::create(['user_id' => $user->id]);

        // ── Ringkasan per kursus yang pernah disentuh siswa ──────────────
        $courses = Course::where('is_active', true)
            ->withCount('lessons')
            ->with([
                'progress' => fn ($q) => $q->where('user_id', $user->id),
            ])
            ->whereHas('progress', fn ($q) => $q->where('user_id', $user->id))
            ->orderBy('title')
            ->get();

        $certificatesByCourseId = Certificate::where('user_id', $user->id)->get()->keyBy('course_id');

        $courseRows = $courses->map(function (Course $course) use ($certificatesByCourseId) {
            $completedLessons = $course->progress->where('status', 'completed')->whereNotNull('lesson_id')->count();
            $totalLessons     = $course->lessons_count ?: $course->total_lessons ?: 0;
            $xpEarned         = (int) $course->progress->whereNotNull('lesson_id')->sum('xp_earned');

            return [
                'course'            => $course,
                'completed_lessons' => $completedLessons,
                'total_lessons'     => $totalLessons,
                'percent'           => $totalLessons > 0 ? (int) min(100, round(($completedLessons / $totalLessons) * 100)) : 0,
                'xp_earned'         => $xpEarned,
                'certificate'       => $certificatesByCourseId->get($course->id),
            ];
        })->sortByDesc('percent')->values();

        // ── Quiz performance keseluruhan ─────────────────────────────────
        $attempts        = QuizAttempt::where('user_id', $user->id)->get();
        $totalAttempts   = $attempts->count();
        $correctAttempts = $attempts->where('is_correct', true)->count();
        $wrongAttempts   = $attempts->where('is_correct', false)->count();
        $quizAccuracy    = $totalAttempts > 0 ? (int) round(($correctAttempts / $totalAttempts) * 100) : 0;
        $quizXpTotal     = (int) $attempts->sum('xp_earned');

        // ── Vocabulary ────────────────────────────────────────────────────
        $completedLessonIds = UserProgress::where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereNotNull('lesson_id')
            ->pluck('lesson_id');

        $vocabTotal    = Vocabulary::count();
        $vocabMastered = Vocabulary::whereIn('lesson_id', $completedLessonIds)->count();

        // ── Pencapaian ────────────────────────────────────────────────────
        $achievementsEarned = $user->achievements()->count();
        $achievementsTotal  = Achievement::where('is_active', true)->count();

        // ── Sertifikat ────────────────────────────────────────────────────
        $certificates = $certificatesByCourseId->values();

        // ── Ringkasan keseluruhan (kartu atas) ────────────────────────────
        $summary = [
            'xp_total'            => $profile->xp_total,
            'level'               => $profile->current_level,
            'streak_days'         => $profile->streak_days,
            'league_label'        => $profile->league_label,
            'courses_touched'     => $courses->count(),
            'courses_completed'   => $courseRows->where('percent', 100)->count(),
            'lessons_completed'   => $completedLessonIds->count(),
            'certificates_count'  => $certificates->count(),
        ];

        return view('learning-report.index', compact(
            'summary',
            'courseRows',
            'totalAttempts',
            'correctAttempts',
            'wrongAttempts',
            'quizAccuracy',
            'quizXpTotal',
            'vocabTotal',
            'vocabMastered',
            'achievementsEarned',
            'achievementsTotal',
            'certificates'
        ));
    }
}

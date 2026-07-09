<?php

namespace App\Services;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Vocabulary;
use App\Models\Achievement;
use App\Models\AiMessage;
use App\Models\QuizAttempt;
use App\Models\StudentProfile;
use App\Models\UserProgress;
use App\Models\UserAchievement;

class DashboardService
{
    /**
     * Get all aggregated student dashboard data.
     *
     * @param  User  $user
     * @return array
     */
    public function getStudentData(User $user): array
    {
        // Profil siswa (dibuat otomatis jika belum ada, supaya statistik
        // XP/streak/level langsung tersedia sejak login pertama).
        $profile = $user->profile ?? StudentProfile::create(['user_id' => $user->id]);

        $today        = now()->startOfDay();
        $startOfWeek  = now()->startOfWeek();
        $startOfMonth = now()->startOfMonth();

        // ── Data dasar dari DB ───────────────────────────────────────────────
        $completedProgress = UserProgress::where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereNotNull('lesson_id');

        $completedLessonIds = (clone $completedProgress)->pluck('lesson_id');
        $lessonsCompletedTotal = $completedLessonIds->count();

        $lessonsToday = (clone $completedProgress)
            ->whereDate('completed_at', $today)
            ->count();

        $questionsToday = QuizAttempt::where('user_id', $user->id)
            ->whereDate('answered_at', $today)
            ->count();

        $totalLessonsActive = Lesson::where('is_active', true)->count();

        // ── Semua course beserta progress user ───────────────────────────────
        $allCourses = Course::where('is_active', true)
            ->withCount('lessons')
            ->with([
                'progress' => fn ($q) => $q->where('user_id', $user->id),
            ])
            ->orderBy('sort_order')
            ->get();

        $totalCourses     = $allCourses->count();
        $coursesCompleted = $allCourses->filter(fn ($c) => $c->calculated_progress >= 100)->count();

        // ── Vocabulary ──────────────────────────────────────────────────────
        $vocabTotal = Vocabulary::count();

        $vocabLessonIdsCompleted = Lesson::where('lesson_type', 'vocabulary')
            ->whereIn('id', $completedLessonIds)
            ->pluck('id');

        $vocabMastered = Vocabulary::whereIn('lesson_id', $vocabLessonIdsCompleted)->count();

        // ── Quiz ────────────────────────────────────────────────────────────
        $quizzesDone = UserProgress::where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereHas('lesson', fn ($q) => $q->where('lesson_type', 'quiz'))
            ->count();

        $totalAttempts   = QuizAttempt::where('user_id', $user->id)->count();
        $correctAttempts = QuizAttempt::where('user_id', $user->id)->where('is_correct', true)->count();
        $avgQuizScore    = $totalAttempts > 0 ? (int) round(($correctAttempts / $totalAttempts) * 100) : 0;

        $completionRate = $totalLessonsActive > 0
            ? (int) round(($lessonsCompletedTotal / $totalLessonsActive) * 100)
            : 0;

        $stats = [
            'lessons_today'     => $lessonsToday,
            'questions_today'   => $questionsToday,
            'streak_days'       => $profile->streak_days,
            'vocab_mastered'    => $vocabMastered,
            'xp_today'          => $profile->xp_today,
            'total_courses'     => $totalCourses,
            'courses_completed' => $coursesCompleted,
            'lessons_completed' => $lessonsCompletedTotal,
            'vocab_total'       => $vocabTotal,
            'quizzes_done'      => $quizzesDone,
            'avg_quiz_score'    => $avgQuizScore,
            'completion_rate'   => $completionRate,
        ];

        // ── Kursus yang sedang berjalan ("Lanjutkan Belajar") ─────────────────
        $courses = $allCourses
            ->filter(fn ($c) => $c->calculated_progress > 0 && $c->calculated_progress < 100)
            ->sortByDesc(fn ($c) => optional($c->progress->sortByDesc('updated_at')->first())->updated_at)
            ->take(5)
            ->values();

        // ── Jalur Pembelajaran: lessons dari course yang sedang dipelajari ─────
        $activeCourse = $courses->first() ?? $allCourses->first();
        $learningPath = [];

        if ($activeCourse) {
            $pathLessons = Lesson::where('course_id', $activeCourse->id)
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get();

            $foundActive = false;
            foreach ($pathLessons as $lesson) {
                $done = $completedLessonIds->contains($lesson->id);
                $active = ! $done && ! $foundActive;
                if ($active) {
                    $foundActive = true;
                }

                $learningPath[] = [
                    'label'  => $lesson->title,
                    'done'   => $done,
                    'active' => $active,
                ];
            }
        }

        // ── Progress Vocabulary per course ──────────────────────────────────
        $vocabProgress = [];
        foreach ($allCourses as $course) {
            $courseVocabTotal = Vocabulary::whereHas('lesson', fn ($q) => $q->where('course_id', $course->id))->count();

            if ($courseVocabTotal === 0) {
                continue;
            }

            $courseVocabMastered = Vocabulary::whereHas('lesson', function ($q) use ($course, $completedLessonIds) {
                $q->where('course_id', $course->id)
                  ->whereIn('id', $completedLessonIds);
            })->count();

            $vocabProgress[] = [
                'name'     => $course->title,
                'mastered' => $courseVocabMastered,
                'total'    => $courseVocabTotal,
                'color'    => $course->color,
            ];
        }
        $vocabProgress = array_slice($vocabProgress, 0, 6);

        // ── Achievements ─────────────────────────────────────────────────────
        $allAchievements = Achievement::where('is_active', true)
            ->where('is_hidden', false)
            ->orderByDesc('created_at')
            ->get();

        $earnedAchievementIds = UserAchievement::where('user_id', $user->id)
            ->pluck('achievement_id')
            ->toArray();

        $earnedRarities = Achievement::whereIn('id', $earnedAchievementIds)
            ->selectRaw('rarity, COUNT(*) as total')
            ->groupBy('rarity')
            ->pluck('total', 'rarity');

        $achievementStats = [
            'earned'         => count($earnedAchievementIds),
            'total'          => $allAchievements->count(),
            'legendary'      => (int) ($earnedRarities['legendary'] ?? 0),
            'epic'           => (int) ($earnedRarities['epic'] ?? 0),
            'rare'           => (int) ($earnedRarities['rare'] ?? 0),
            'common'         => (int) ($earnedRarities['common'] ?? 0),
            'completion_pct' => $allAchievements->count() > 0
                ? (int) round((count($earnedAchievementIds) / $allAchievements->count()) * 100)
                : 0,
        ];

        // ── Rekomendasi kursus ────────────────────────────────────────────────
        $recommendations = $allCourses
            ->filter(fn ($c) => $c->calculated_progress === 0)
            ->sortByDesc(fn ($c) => [$c->difficulty === 'beginner' ? 1 : 0, $c->rating])
            ->take(4)
            ->values();

        // ── Tantangan Harian ─────────────────────────────────────────────────
        $nextLesson = Lesson::where('is_active', true)
            ->whereNotIn('id', $completedLessonIds)
            ->orderBy('course_id')
            ->orderBy('sort_order')
            ->first();

        $dailyChallenge = $nextLesson
            ? [
                'title'       => $nextLesson->title,
                'description' => $nextLesson->description ?? 'Selesaikan pelajaran ini untuk mendapatkan XP.',
                'xp_reward'   => $nextLesson->xp_reward,
                'time_limit'  => $nextLesson->duration_minutes . ' menit',
                'difficulty'  => $nextLesson->lesson_type_label,
            ]
            : [
                'title'       => 'Semua pelajaran selesai',
                'description' => 'Kerja bagus! Tidak ada pelajaran baru yang tersisa saat ini.',
                'xp_reward'   => 0,
                'time_limit'  => '-',
                'difficulty'  => '-',
            ];

        // ── Statistik AI Tutor ───────────────────────────────────────────────
        $conversationIds = $user->conversations()->pluck('id');
        $aiMessagesQuery = AiMessage::whereIn('conversation_id', $conversationIds);

        $chart = [];
        $dayLabels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = (clone $aiMessagesQuery)->whereDate('created_at', $date->toDateString())->count();
            $chart[] = [
                'date'  => $dayLabels[$date->dayOfWeekIso - 1],
                'count' => $count,
            ];
        }

        $aiTutorStats = [
            'sessions'             => $conversationIds->count(),
            'questions'            => (clone $aiMessagesQuery)->where('role', 'user')->count(),
            'accuracy'             => 0,
            'total_conversations'  => $conversationIds->count(),
            'total_messages'       => (clone $aiMessagesQuery)->count(),
            'today'                => (clone $aiMessagesQuery)->whereDate('created_at', $today)->count(),
            'this_week'            => (clone $aiMessagesQuery)->where('created_at', '>=', $startOfWeek)->count(),
            'this_month'           => (clone $aiMessagesQuery)->where('created_at', '>=', $startOfMonth)->count(),
            'weekly_activity'      => array_column($chart, 'count'),
            'chart'                => $chart,
        ];

        // ── Leaderboard ──────────────────────────────────────────────────────
        $leaderboard = StudentProfile::with('user:id,name,role')
            ->whereHas('user', fn ($q) => $q->where('role', 'student'))
            ->orderByDesc('xp_total')
            ->take(10)
            ->get()
            ->map(fn ($p) => [
                'name'   => $p->user->name ?? 'Pengguna',
                'xp'     => $p->xp_total,
                'color'  => $p->league_color,
                'is_me'  => $p->user_id === $user->id,
            ])
            ->values();

        // ── Aktivitas terbaru ─────────────────────────────────────────────────
        $recentLessonActivities = UserProgress::with('lesson')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->take(5)
            ->get()
            ->map(fn ($p) => [
                'type'  => 'lesson',
                'title' => 'Menyelesaikan pelajaran "' . ($p->lesson->title ?? '-') . '"',
                'time'  => $p->completed_at,
                'xp'    => $p->xp_earned,
                'color' => '#22C55E',
            ]);

        $recentAchievementActivities = UserAchievement::with('achievement')
            ->where('user_id', $user->id)
            ->whereNotNull('earned_at')
            ->latest('earned_at')
            ->take(5)
            ->get()
            ->map(fn ($ua) => [
                'type'  => 'achievement',
                'title' => 'Meraih pencapaian "' . ($ua->achievement->title ?? '-') . '"',
                'time'  => $ua->earned_at,
                'xp'    => $ua->achievement->xp_reward ?? null,
                'color' => '#F59E0B',
            ]);

        $recentActivities = $recentLessonActivities
            ->concat($recentAchievementActivities)
            ->sortByDesc('time')
            ->take(8)
            ->values();

        // ── Pelajaran berikutnya ──────────────────────────────────────────────
        $upcomingLessons = Lesson::with('course')
            ->where('is_active', true)
            ->whereNotIn('id', $completedLessonIds)
            ->orderBy('course_id')
            ->orderBy('sort_order')
            ->take(4)
            ->get()
            ->map(fn ($l) => [
                'title'    => $l->title,
                'course'   => $l->course->title ?? '-',
                'duration' => $l->duration_minutes . ' menit',
                'color'    => $l->lesson_type_color,
            ]);

        return compact(
            'profile', 'stats', 'courses', 'learningPath', 'vocabProgress',
            'allAchievements', 'earnedAchievementIds', 'achievementStats',
            'recommendations', 'dailyChallenge', 'aiTutorStats', 'leaderboard',
            'recentActivities', 'upcomingLessons'
        );
    }
}

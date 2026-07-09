<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentLessonController extends Controller
{
    // =========================================================
    // SHOW — Halaman detail lesson untuk student
    // Route: GET /courses/{slug}/lessons/{lesson}
    // {lesson} = Lesson ID (integer, model binding)
    // =========================================================

    public function show(string $slug, Lesson $lesson)
    {
        $userId = Auth::id();

        // Resolve course dari slug, pastikan aktif
        $course = Course::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Pastikan lesson milik course ini dan aktif
        abort_if($lesson->course_id !== $course->id || ! $lesson->is_active, 404);

        // Load relasi yang dibutuhkan di lesson
        $lesson->load([
            'vocabularies' => fn ($q) => $q->orderBy('sort_order'),
            'quizzes'      => fn ($q) => $q->orderBy('sort_order'),
        ]);

        // Progress user untuk lesson ini
        $progress = UserProgress::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        $isCompleted  = $progress && $progress->status === 'completed';
        $isInProgress = $progress && $progress->status === 'in_progress';

        // Jika belum ada progress, buat in_progress otomatis saat buka halaman
        if (! $progress) {
            UserProgress::create([
                'user_id'   => $userId,
                'course_id' => $course->id,
                'lesson_id' => $lesson->id,
                'status'    => 'in_progress',
                'xp_earned' => 0,
                'attempts'  => 1,
            ]);
            $isInProgress = true;
        }

        // Semua lesson aktif di course ini, urut sort_order
        $allLessons = Lesson::where('course_id', $course->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'title', 'slug', 'lesson_type', 'sort_order', 'xp_reward', 'duration_minutes']);

        // Prev / Next lesson
        $prevLesson = $allLessons
            ->where('sort_order', '<', $lesson->sort_order)
            ->sortByDesc('sort_order')
            ->first();

        $nextLesson = $allLessons
            ->where('sort_order', '>', $lesson->sort_order)
            ->sortBy('sort_order')
            ->first();

        // Progress semua lesson di course ini (untuk sidebar checklist)
        $completedLessonIds = UserProgress::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->where('status', 'completed')
            ->whereNotNull('lesson_id')
            ->pluck('lesson_id')
            ->toArray();

        // Progress course secara keseluruhan
        $totalLessons    = $allLessons->count();
        $completedCount  = count($completedLessonIds);
        $courseProgressPct = $totalLessons > 0
            ? (int) min(100, round(($completedCount / $totalLessons) * 100))
            : 0;

        // Posisi lesson saat ini di dalam daftar
        $lessonIndex = $allLessons->search(fn ($l) => $l->id === $lesson->id);
        $lessonNumber = $lessonIndex !== false ? $lessonIndex + 1 : 1;

        return view('courses.lessons.show', compact(
            'course',
            'lesson',
            'allLessons',
            'prevLesson',
            'nextLesson',
            'isCompleted',
            'isInProgress',
            'completedLessonIds',
            'completedCount',
            'totalLessons',
            'courseProgressPct',
            'lessonNumber',
            'progress'
        ));
    }
}
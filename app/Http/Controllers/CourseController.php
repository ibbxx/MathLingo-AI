<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\UserProgress;
use App\Models\Certificate;
use App\Notifications\CertificateIssued;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // =========================================================
    // INDEX
    // =========================================================

    public function index(Request $request)
    {
        $userId = Auth::id();

        $query = Course::where('is_active', true)
            ->withCount([
                'lessons',
                'lessons as vocabulary_count' => fn ($q) => $q->where('lesson_type', 'vocabulary'),
                'lessons as quiz_count'        => fn ($q) => $q->where('lesson_type', 'quiz'),
            ])
            ->with([
                'favoritedByUsers' => fn ($q) => $q->where('user_id', $userId),
                'progress'         => fn ($q) => $q->where('user_id', $userId),
            ]);

        if ($request->filled('search')) {
            $term = $request->input('search');
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', '%' . $term . '%')
                  ->orWhere('description', 'like', '%' . $term . '%')
                  ->orWhere('category', 'like', '%' . $term . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->input('difficulty'));
        }

        $sort  = $request->input('sort', 'sort_order');
        $query = match ($sort) {
            'newest'   => $query->orderByDesc('created_at'),
            'oldest'   => $query->orderBy('created_at'),
            'az'       => $query->orderBy('title'),
            'xp'       => $query->orderByDesc('total_xp'),
            'lessons'  => $query->orderByDesc('total_lessons'),
            'duration' => $query->orderByDesc('estimated_minutes'),
            'rating'   => $query->orderByDesc('rating'),
            default    => $query->orderBy('sort_order'),
        };

        $courses = $query->paginate(12)->withQueryString();

        $allCourses = Course::where('is_active', true)
            ->withCount([
                'lessons',
                'lessons as vocabulary_count' => fn ($q) => $q->where('lesson_type', 'vocabulary'),
            ])
            ->with([
                'favoritedByUsers' => fn ($q) => $q->where('user_id', $userId),
                'progress'         => fn ($q) => $q->where('user_id', $userId),
            ])
            ->orderBy('sort_order')
            ->get();

        $continueLearning = $allCourses->filter(
            fn ($c) => $c->calculated_progress > 0 && $c->calculated_progress < 100
        )->values();

        $recommendedCourses = $allCourses->filter(
            fn ($c) => $c->calculated_progress === 0 && $c->difficulty === 'beginner'
        )->take(6)->values();

        $favoriteCourses = $allCourses->filter(fn ($c) => $c->is_favorited)->values();

        $categories = Course::where('is_active', true)
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $difficulties = collect(['beginner', 'intermediate', 'advanced']);

        $userStats = $this->getUserStats($userId);

        $totalCourses    = $allCourses->count();
        $totalLessons    = $allCourses->sum('lessons_count');
        $totalVocabulary = $allCourses->sum('vocabulary_count');
        $totalXp         = $allCourses->sum('total_xp');

        return view('courses.index', compact(
            'courses',
            'continueLearning',
            'recommendedCourses',
            'favoriteCourses',
            'categories',
            'difficulties',
            'userStats',
            'totalCourses',
            'totalLessons',
            'totalVocabulary',
            'totalXp',
            'sort'
        ));
    }

    // =========================================================
    // SHOW
    // =========================================================

    public function show(string $slug)
    {
        $userId = Auth::id();

        $course = Course::where('slug', $slug)
            ->where('is_active', true)
            ->withCount([
                'lessons as lessons_count'    => fn ($q) => $q->where('is_active', true),
                'lessons as vocabulary_count' => fn ($q) => $q->where('is_active', true)->where('lesson_type', 'vocabulary'),
                'lessons as quiz_count'       => fn ($q) => $q->where('is_active', true)->where('lesson_type', 'quiz'),
            ])
            ->with([
                'lessons'          => fn ($q) => $q->where('is_active', true)->orderBy('sort_order'),
                'progress'         => fn ($q) => $q->where('user_id', $userId),
                'favoritedByUsers' => fn ($q) => $q->where('user_id', $userId),
            ])
            ->firstOrFail();

        // Status lesson HANYA dari user_progress
        $completedLessonIds  = $course->progress
            ->where('status', 'completed')
            ->whereNotNull('lesson_id')
            ->pluck('lesson_id')
            ->toArray();

        $inProgressLessonIds = $course->progress
            ->where('status', 'in_progress')
            ->whereNotNull('lesson_id')
            ->pluck('lesson_id')
            ->toArray();

        $lessons = $course->lessons->map(function ($lesson) use ($completedLessonIds, $inProgressLessonIds) {
            $lesson->is_completed   = in_array($lesson->id, $completedLessonIds);
            $lesson->is_in_progress = in_array($lesson->id, $inProgressLessonIds);
            return $lesson;
        });

        $vocabularyLessons = $lessons->filter(fn ($l) => $l->lesson_type === 'vocabulary')->values();
        $quizLessons       = $lessons->filter(fn ($l) => $l->lesson_type === 'quiz')->values();
        $nextLesson        = $lessons->first(fn ($l) => ! $l->is_completed);
        $completedCount    = count($completedLessonIds);

        $progressPct = $course->lessons_count > 0
            ? (int) min(100, round(($completedCount / $course->lessons_count) * 100))
            : 0;

        $relatedCourses = Course::where('is_active', true)
            ->where('id', '!=', $course->id)
            ->where(function ($q) use ($course) {
                $q->where('category', $course->category)
                  ->orWhere('difficulty', $course->difficulty);
            })
            ->withCount([
                'lessons as lessons_count' => fn ($q) => $q->where('is_active', true),
            ])
            ->with([
                'progress'         => fn ($q) => $q->where('user_id', $userId),
                'favoritedByUsers' => fn ($q) => $q->where('user_id', $userId),
            ])
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        return view('courses.show', compact(
            'course',
            'lessons',
            'vocabularyLessons',
            'quizLessons',
            'nextLesson',
            'completedCount',
            'progressPct',
            'relatedCourses'
        ));
    }

    // =========================================================
    // TOGGLE FAVORITE
    // Route: POST /courses/{slug}/favorite
    // =========================================================

    public function toggleFavorite(string $slug)
    {
        $user   = Auth::user();
        $course = Course::where('slug', $slug)->where('is_active', true)->firstOrFail();

        if ($course->favoritedByUsers()->where('user_id', $user->id)->exists()) {
            $course->favoritedByUsers()->detach($user->id);
            $favorited = false;
        } else {
            $course->favoritedByUsers()->attach($user->id);
            $favorited = true;
        }

        if (request()->expectsJson()) {
            return response()->json(['favorited' => $favorited]);
        }

        return back();
    }

    // =========================================================
    // START LESSON
    // Route: POST /courses/{slug}/lessons/{lesson}/start
    // Menulis user_progress status = in_progress
    // {lesson} = Lesson model binding by ID (integer)
    // =========================================================

    public function startLesson(string $slug, Lesson $lesson)
    {
        $userId = Auth::id();
 
        $course = Course::where('slug', $slug)->where('is_active', true)->firstOrFail();
 
        abort_if($lesson->course_id !== $course->id || ! $lesson->is_active, 404);
 
        $existing = UserProgress::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->where('lesson_id', $lesson->id)
            ->first();
 
        if (! $existing) {
            UserProgress::create([
                'user_id'   => $userId,
                'course_id' => $course->id,
                'lesson_id' => $lesson->id,
                'status'    => 'in_progress',
                'xp_earned' => 0,
                'attempts'  => 1,
            ]);
        } elseif ($existing->status === 'not_started') {
            $existing->update([
                'status'   => 'in_progress',
                'attempts' => $existing->attempts + 1,
            ]);
        }
 
        // Redirect ke halaman detail lesson (bukan course.show)
        return redirect()->route('courses.lessons.show', [$slug, $lesson->id]);
    }
 
    // =========================================================
    // COMPLETE LESSON
    // Route: POST /courses/{slug}/lessons/{lesson}/complete
    // =========================================================
 
    public function completeLesson(string $slug, Lesson $lesson)
    {
        $userId = Auth::id();
 
        $course = Course::where('slug', $slug)->where('is_active', true)->firstOrFail();
 
        abort_if($lesson->course_id !== $course->id || ! $lesson->is_active, 404);
 
        UserProgress::updateOrCreate(
            [
                'user_id'   => $userId,
                'course_id' => $course->id,
                'lesson_id' => $lesson->id,
            ],
            [
                'status'       => 'completed',
                'xp_earned'    => $lesson->xp_reward ?? 0,
                'completed_at' => now(),
            ]
        );
 
        // Kalau lesson ini adalah lesson terakhir yang bikin course-nya 100% selesai,
        // catat baris progress level-course (lesson_id null) + terbitkan sertifikat.
        $certificate = null;
        $totalActiveLessons = $course->activeLessons()->count();
        $completedLessonCount = UserProgress::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->where('status', 'completed')
            ->whereNotNull('lesson_id')
            ->count();
 
        if ($totalActiveLessons > 0 && $completedLessonCount >= $totalActiveLessons) {
            UserProgress::updateOrCreate(
                ['user_id' => $userId, 'course_id' => $course->id, 'lesson_id' => null],
                ['status' => 'completed', 'completed_at' => now()]
            );
 
            $wasAlreadyIssued = Certificate::where('user_id', $userId)->where('course_id', $course->id)->exists();
            $certificate = Certificate::issueForCompletedCourse(Auth::user(), $course);
 
            if ($certificate && ! $wasAlreadyIssued) {
                Auth::user()->notify(new \App\Notifications\CertificateIssued($certificate));
            }
        }
 
        if (request()->expectsJson()) {
            return response()->json([
                'success'      => true,
                'xp_earned'    => $lesson->xp_reward ?? 0,
                'certificate'  => $certificate ? [
                    'id'     => $certificate->id,
                    'number' => $certificate->certificate_number,
                    'url'    => route('certificates.show', $certificate->id),
                ] : null,
            ]);
        }
 
        // Redirect ke halaman detail lesson agar student bisa lihat jawaban quiz
        // dan klik tombol "Selanjutnya"
        return redirect()->route('courses.lessons.show', [$slug, $lesson->id]);
    }

    // =========================================================
    // PRIVATE HELPERS
    // =========================================================

    private function getUserStats(?int $userId): array
    {
        if (! $userId) {
            return [
                'total_xp'            => 0,
                'completed_lessons'   => 0,
                'completed_courses'   => 0,
                'vocabulary_mastered' => 0,
            ];
        }

        $progress = UserProgress::where('user_id', $userId)->get();

        return [
            'total_xp'            => (int) $progress->sum('xp_earned'),
            'completed_lessons'   => $progress->where('status', 'completed')->whereNotNull('lesson_id')->count(),
            'completed_courses'   => $progress->where('status', 'completed')->whereNull('lesson_id')->count(),
            'vocabulary_mastered' => 0,
        ];
    }
}
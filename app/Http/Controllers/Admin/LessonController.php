<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLessonRequest;
use App\Http\Requests\Admin\UpdateLessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LessonController extends Controller
{
    // =========================================================
    // INDEX
    // =========================================================

    public function index(Request $request): View
    {
        $query = Lesson::with('course')
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = $request->input('search');
                $q->where(function ($sub) use ($term) {
                    $sub->where('title', 'like', "%{$term}%")
                        ->orWhere('slug', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%");
                });
            })
            ->when($request->filled('course_id'), fn ($q) => $q->where('course_id', $request->input('course_id')))
            ->when($request->filled('lesson_type'), fn ($q) => $q->where('lesson_type', $request->input('lesson_type')))
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('is_active', $request->input('status') === 'active' ? 1 : 0);
            });

        $sort = $request->input('sort', 'sort_order');
        $query = match ($sort) {
            'newest'   => $query->orderByDesc('created_at'),
            'oldest'   => $query->orderBy('created_at'),
            'az'       => $query->orderBy('title'),
            'za'       => $query->orderByDesc('title'),
            'xp'       => $query->orderByDesc('xp_reward'),
            'duration' => $query->orderByDesc('duration_minutes'),
            'course'   => $query->orderBy('course_id')->orderBy('sort_order'),
            default    => $query->orderBy('sort_order')->orderBy('id'),
        };

        $perPage = in_array((int) $request->input('per_page'), [10, 25, 50, 100])
            ? (int) $request->input('per_page')
            : 25;

        $lessons = $query->paginate($perPage)->withQueryString();

        $courses = Course::orderBy('title')->get(['id', 'title']);

        $stats = [
            'total'        => Lesson::count(),
            'active'       => Lesson::where('is_active', true)->count(),
            'inactive'     => Lesson::where('is_active', false)->count(),
            'total_xp'     => Lesson::sum('xp_reward'),
            'total_minutes'=> Lesson::sum('duration_minutes'),
            'total_courses' => Lesson::distinct('course_id')->count('course_id'),
        ];

        $lessonTypes = [
            'vocabulary' => 'Vocabulary',
            'reading'    => 'Reading',
            'grammar'    => 'Grammar',
            'practice'   => 'Practice',
            'quiz'       => 'Quiz',
        ];

        return view('admin.lessons.index', compact('lessons', 'courses', 'stats', 'lessonTypes', 'sort', 'perPage'));
    }

    // =========================================================
    // CREATE
    // =========================================================

    public function create(Request $request): View
    {
        $courses = Course::orderBy('title')->get(['id', 'title', 'status']);
        $selectedCourseId = $request->input('course_id');
        $maxSortOrder = 0;

        if ($selectedCourseId) {
            $maxSortOrder = Lesson::where('course_id', $selectedCourseId)->max('sort_order') ?? 0;
        }

        $lessonTypes = [
            'vocabulary' => 'Vocabulary',
            'reading'    => 'Reading',
            'grammar'    => 'Grammar',
            'practice'   => 'Practice',
            'quiz'       => 'Quiz',
        ];

        return view('admin.lessons.create', compact('courses', 'selectedCourseId', 'maxSortOrder', 'lessonTypes'));
    }

    // =========================================================
    // STORE
    // =========================================================

    public function store(StoreLessonRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('lesson-images', 'public');
        } else {
            unset($validated['image']);
        }

        DB::transaction(function () use ($validated) {
            if (empty($validated['slug'])) {
                $validated['slug'] = $this->generateUniqueSlug($validated['title'], $validated['course_id']);
            }

            Lesson::create($validated);
        });

        return redirect()
            ->route('admin.lessons.index')
            ->with('success', 'Pelajaran berhasil dibuat.');
    }

    // =========================================================
    // SHOW
    // =========================================================

    public function show(Lesson $lesson): View
    {
        $lesson->load([
            'course',
            'vocabularies' => fn ($q) => $q->orderBy('sort_order'),
            'quizzes'      => fn ($q) => $q->orderBy('sort_order'),
        ]);

        $prevLesson = Lesson::where('course_id', $lesson->course_id)
            ->where('sort_order', '<', $lesson->sort_order)
            ->orderByDesc('sort_order')
            ->first();

        $nextLesson = Lesson::where('course_id', $lesson->course_id)
            ->where('sort_order', '>', $lesson->sort_order)
            ->orderBy('sort_order')
            ->first();

        $vocabularyCount = $lesson->vocabularies->count();
        $quizCount = $lesson->quizzes->count();

        return view('admin.lessons.show', compact('lesson', 'prevLesson', 'nextLesson', 'vocabularyCount', 'quizCount'));
    }

    // =========================================================
    // EDIT
    // =========================================================

    public function edit(Lesson $lesson): View
    {
        $lesson->load('course');
        $courses = Course::orderBy('title')->get(['id', 'title', 'status']);

        $lessonTypes = [
            'vocabulary' => 'Vocabulary',
            'reading'    => 'Reading',
            'grammar'    => 'Grammar',
            'practice'   => 'Practice',
            'quiz'       => 'Quiz',
        ];

        return view('admin.lessons.edit', compact('lesson', 'courses', 'lessonTypes'));
    }

    // =========================================================
    // UPDATE
    // =========================================================

    public function update(UpdateLessonRequest $request, Lesson $lesson): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($lesson->image) {
                Storage::disk('public')->delete($lesson->image);
            }
            $validated['image'] = $request->file('image')->store('lesson-images', 'public');
        } elseif ($request->boolean('remove_image') && $lesson->image) {
            Storage::disk('public')->delete($lesson->image);
            $validated['image'] = null;
        } else {
            unset($validated['image']);
        }
        unset($validated['remove_image']);

        DB::transaction(function () use ($validated, $lesson) {
            $lesson->update($validated);
        });

        return redirect()
            ->route('admin.lessons.index')
            ->with('success', 'Pelajaran berhasil diperbarui.');
    }

    // =========================================================
    // DESTROY
    // =========================================================

    public function destroy(Lesson $lesson): RedirectResponse
    {
        $title = $lesson->title;

        if ($lesson->image) {
            Storage::disk('public')->delete($lesson->image);
        }

        $lesson->delete();

        return redirect()
            ->route('admin.lessons.index')
            ->with('success', "Pelajaran \"{$title}\" berhasil dihapus.");
    }

    // =========================================================
    // UPLOAD CONTENT IMAGE (dipakai oleh editor Konten Pelajaran)
    // =========================================================

    public function uploadContentImage(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png,webp,gif', 'max:4096'],
        ]);

        $path = $request->file('image')->store('lesson-content-images', 'public');

        return response()->json([
            'url' => Storage::disk('public')->url($path),
        ]);
    }

    // =========================================================
    // PRIVATE HELPERS
    // =========================================================

    private function generateUniqueSlug(string $title, int $courseId, ?int $exceptId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (
            Lesson::where('course_id', $courseId)
                ->where('slug', $slug)
                ->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))
                ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
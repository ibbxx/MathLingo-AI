<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuizRequest;
use App\Http\Requests\Admin\UpdateQuizRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Support\PublicStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizController extends Controller
{
    // =========================================================
    // INDEX
    // =========================================================

    public function index(Request $request): View
    {
        $query = Quiz::with('lesson.course')
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = $request->input('search');
                $q->where('question', 'like', "%{$term}%");
            })
            ->when($request->filled('lesson_id'), fn ($q) => $q->where('lesson_id', $request->input('lesson_id')))
            ->when($request->filled('course_id'), function ($q) use ($request) {
                $q->whereHas('lesson', fn ($sub) => $sub->where('course_id', $request->input('course_id')));
            })
            ->when($request->filled('question_type'), fn ($q) => $q->where('question_type', $request->input('question_type')))
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('is_active', $request->input('status') === 'active' ? 1 : 0);
            });

        $sort = $request->input('sort', 'sort_order');
        $query = match ($sort) {
            'newest' => $query->orderByDesc('created_at'),
            'oldest' => $query->orderBy('created_at'),
            'xp'     => $query->orderByDesc('xp_reward'),
            'lesson' => $query->orderBy('lesson_id')->orderBy('sort_order'),
            default  => $query->orderBy('sort_order')->orderBy('id'),
        };

        $perPage = in_array((int) $request->input('per_page'), [10, 25, 50, 100])
            ? (int) $request->input('per_page')
            : 25;

        $quizzes = $query->paginate($perPage)->withQueryString();

        $courses = Course::orderBy('title')->get(['id', 'title']);
        $lessons = Lesson::orderBy('title')->get(['id', 'title', 'course_id']);

        $questionTypes = [
            'multiple_choice' => 'Multiple Choice',
            'word_arrange'    => 'Essay (Susun Kata)',
        ];

        $stats = [
            'total'        => Quiz::count(),
            'active'       => Quiz::where('is_active', true)->count(),
            'inactive'     => Quiz::where('is_active', false)->count(),
            'total_xp'     => Quiz::sum('xp_reward'),
            'total_lessons'=> Quiz::distinct('lesson_id')->count('lesson_id'),
        ];

        return view('admin.quizzes.index', compact('quizzes', 'courses', 'lessons', 'questionTypes', 'stats', 'sort', 'perPage'));
    }

    // =========================================================
    // CREATE
    // =========================================================
     public function create(Request $request): View
    {
        $lessons = Lesson::with('course')->orderBy('title')->get(['id', 'title', 'course_id']);
        $courses = Course::orderBy('title')->get(['id', 'title']);
        $selectedLessonId = $request->input('lesson_id');

        $questionTypes = [
            'multiple_choice' => 'Multiple Choice',
            'word_arrange'    => 'Essay (Susun Kata)',
        ];

        return view('admin.quizzes.create', compact('lessons', 'courses', 'selectedLessonId', 'questionTypes'));
    }

    // Store
    public function store(StoreQuizRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $lessonId = $data['lesson_id'];

        $nextSortOrder = (Quiz::where('lesson_id', $lessonId)->max('sort_order') ?? 0) + 1;

        foreach ($data['soal'] as $i => $item) {
            $item['lesson_id'] = $lessonId;

            if (empty($item['sort_order'])) {
                $item['sort_order'] = $nextSortOrder++;
            }

            // File upload per-soal: soal.{i}.image
            $file = $request->file("soal.{$i}.image");
            if ($file) {
                $item['image'] = PublicStorage::store($file, 'quiz-images');
            } else {
                unset($item['image']);
            }

            unset($item['options_raw'], $item['correct_answer_order']);

            Quiz::create($item);
        }

        $count = count($data['soal']);

        return redirect()
            ->route('admin.quizzes.index', ['lesson_id' => $lessonId])
            ->with('success', "{$count} soal quiz berhasil ditambahkan sekaligus.");
    }

    // =========================================================
    // EDIT
    // =========================================================

    public function edit(Quiz $quiz): View
    {
        $quiz->load('lesson.course');
        $lessons = Lesson::with('course')->orderBy('title')->get(['id', 'title', 'course_id']);
        $courses = Course::orderBy('title')->get(['id', 'title']);

        $questionTypes = [
            'multiple_choice' => 'Multiple Choice',
            'word_arrange'    => 'Essay (Susun Kata)',
        ];

        return view('admin.quizzes.edit', compact('quiz', 'lessons', 'courses', 'questionTypes'));
    }

    // =========================================================
    // UPDATE
    // =========================================================

    public function update(UpdateQuizRequest $request, Quiz $quiz): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($quiz->image) {
                PublicStorage::delete($quiz->image);
            }
            $data['image'] = PublicStorage::store($request->file('image'), 'quiz-images');
        } elseif ($request->boolean('remove_image') && $quiz->image) {
            PublicStorage::delete($quiz->image);
            $data['image'] = null;
        } else {
            unset($data['image']);
        }

        $quiz->update($data);

        return redirect()
            ->route('admin.quizzes.index', ['lesson_id' => $quiz->lesson_id])
            ->with('success', 'Soal quiz berhasil diperbarui.');
    }

    // =========================================================
    // DESTROY
    // =========================================================

    public function destroy(Quiz $quiz): RedirectResponse
    {
        $lessonId = $quiz->lesson_id;

        if ($quiz->image) {
            PublicStorage::delete($quiz->image);
        }

        $quiz->delete();

        return redirect()
            ->route('admin.quizzes.index', ['lesson_id' => $lessonId])
            ->with('success', 'Soal quiz berhasil dihapus.');
    }
}

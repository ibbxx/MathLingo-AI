<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreVocabularyRequest;
use App\Http\Requests\Admin\UpdateVocabularyRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Vocabulary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class VocabularyController extends Controller
{
    // =========================================================
    // INDEX
    // =========================================================

    public function index(Request $request): View
    {
        $query = Vocabulary::with('lesson.course')
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = $request->input('search');
                $q->where(function ($sub) use ($term) {
                    $sub->where('term', 'like', "%{$term}%")
                        ->orWhere('translation', 'like', "%{$term}%")
                        ->orWhere('mathematical_meaning', 'like', "%{$term}%");
                });
            })
            ->when($request->filled('lesson_id'), fn ($q) => $q->where('lesson_id', $request->input('lesson_id')))
            ->when($request->filled('course_id'), function ($q) use ($request) {
                $q->whereHas('lesson', fn ($sub) => $sub->where('course_id', $request->input('course_id')));
            })
            ->when($request->filled('difficulty'), fn ($q) => $q->where('difficulty', $request->input('difficulty')));

        $sort = $request->input('sort', 'sort_order');
        $query = match ($sort) {
            'newest' => $query->orderByDesc('created_at'),
            'oldest' => $query->orderBy('created_at'),
            'az'     => $query->orderBy('term'),
            'za'     => $query->orderByDesc('term'),
            'lesson' => $query->orderBy('lesson_id')->orderBy('sort_order'),
            default  => $query->orderBy('sort_order')->orderBy('id'),
        };

        $perPage = in_array((int) $request->input('per_page'), [10, 25, 50, 100])
            ? (int) $request->input('per_page')
            : 25;

        $vocabularies = $query->paginate($perPage)->withQueryString();

        $courses = Course::orderBy('title')->get(['id', 'title']);
        $lessons = Lesson::orderBy('title')->get(['id', 'title', 'course_id']);

        $stats = [
            'total'        => Vocabulary::count(),
            'beginner'     => Vocabulary::where('difficulty', 'beginner')->count(),
            'intermediate' => Vocabulary::where('difficulty', 'intermediate')->count(),
            'advanced'     => Vocabulary::where('difficulty', 'advanced')->count(),
            'total_lessons'=> Vocabulary::distinct('lesson_id')->count('lesson_id'),
        ];

        return view('admin.vocabulary.index', compact('vocabularies', 'courses', 'lessons', 'stats', 'sort', 'perPage'));
    }

    // =========================================================
    // CREATE
    // =========================================================

    public function create(Request $request): View
    {
        $lessons = Lesson::with('course')->orderBy('title')->get(['id', 'title', 'course_id']);
        $courses = Course::orderBy('title')->get(['id', 'title']);
        $selectedLessonId = $request->input('lesson_id');
        $maxSortOrder = 0;

        if ($selectedLessonId) {
            $maxSortOrder = Vocabulary::where('lesson_id', $selectedLessonId)->max('sort_order') ?? 0;
        }

        return view('admin.vocabulary.create', compact('lessons', 'courses', 'selectedLessonId', 'maxSortOrder'));
    }

    // =========================================================
    // STORE
    // =========================================================

    public function store(StoreVocabularyRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('vocabulary-images', 'public');
        } else {
            unset($data['image']);
        }

        $vocabulary = Vocabulary::create($data);

        return redirect()
            ->route('admin.vocabulary.index', ['lesson_id' => $vocabulary->lesson_id])
            ->with('success', "Kosakata \"{$vocabulary->term}\" berhasil ditambahkan.");
    }

    // =========================================================
    // EDIT
    // =========================================================

    public function edit(Vocabulary $vocabulary): View
    {
        $vocabulary->load('lesson.course');
        $lessons = Lesson::with('course')->orderBy('title')->get(['id', 'title', 'course_id']);
        $courses = Course::orderBy('title')->get(['id', 'title']);

        return view('admin.vocabulary.edit', compact('vocabulary', 'lessons', 'courses'));
    }

    // =========================================================
    // UPDATE
    // =========================================================

    public function update(UpdateVocabularyRequest $request, Vocabulary $vocabulary): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($vocabulary->image) {
                Storage::disk('public')->delete($vocabulary->image);
            }
            $data['image'] = $request->file('image')->store('vocabulary-images', 'public');
        } elseif ($request->boolean('remove_image') && $vocabulary->image) {
            Storage::disk('public')->delete($vocabulary->image);
            $data['image'] = null;
        } else {
            unset($data['image']);
        }
        unset($data['remove_image']);

        $vocabulary->update($data);

        return redirect()
            ->route('admin.vocabulary.index', ['lesson_id' => $vocabulary->lesson_id])
            ->with('success', "Kosakata \"{$vocabulary->term}\" berhasil diperbarui.");
    }

    // =========================================================
    // DESTROY
    // =========================================================

    public function destroy(Vocabulary $vocabulary): RedirectResponse
    {
        $term = $vocabulary->term;
        $lessonId = $vocabulary->lesson_id;

        if ($vocabulary->image) {
            Storage::disk('public')->delete($vocabulary->image);
        }

        $vocabulary->delete();

        return redirect()
            ->route('admin.vocabulary.index', ['lesson_id' => $lessonId])
            ->with('success', "Kosakata \"{$term}\" berhasil dihapus.");
    }
}

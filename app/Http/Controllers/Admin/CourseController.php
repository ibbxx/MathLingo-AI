<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCourseRequest;
use App\Http\Requests\Admin\UpdateCourseRequest;
use App\Models\Course;
use App\Models\User;
use App\Notifications\NewCourseAvailable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CourseController extends Controller
{
    // =========================================================
    // INDEX
    // =========================================================

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Course::class);

        $query = Course::query()
            ->withCount('lessons')
            ->withCount(['progress as students_enrolled' => fn ($q) => $q->whereNull('lesson_id')->distinct('user_id')])
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = $request->input('search');
                $q->where(function ($sub) use ($term) {
                    $sub->where('title', 'like', "%{$term}%")
                        ->orWhere('slug', 'like', "%{$term}%")
                        ->orWhere('category', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%");
                });
            })
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->input('category')))
            ->when($request->filled('difficulty'), fn ($q) => $q->where('difficulty', $request->input('difficulty')))
            ->when($request->filled('status'), function ($q) use ($request) {
                if ($request->input('status') === 'trashed') {
                    $q->onlyTrashed();
                } else {
                    $q->where('status', $request->input('status'));
                }
            })
            ->when($request->filled('featured'), fn ($q) => $q->where('is_featured', $request->boolean('featured')));

        $sort = $request->input('sort', 'sort_order');
        $query = match ($sort) {
            'newest'   => $query->orderByDesc('created_at'),
            'oldest'   => $query->orderBy('created_at'),
            'az'       => $query->orderBy('title'),
            'za'       => $query->orderByDesc('title'),
            'students' => $query->orderByDesc('students_count'),
            'lessons'  => $query->orderByDesc('lessons_count'),
            default    => $query->orderBy('sort_order')->orderBy('id'),
        };

        $perPage = in_array((int) $request->input('per_page'), [10, 25, 50, 100])
            ? (int) $request->input('per_page')
            : 25;

        $courses = $query->paginate($perPage)->withQueryString();

        $categories = Course::withTrashed()
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $stats = [
            'total'     => Course::count(),
            'published' => Course::where('status', 'published')->count(),
            'draft'     => Course::where('status', 'draft')->count(),
            'archived'  => Course::where('status', 'archived')->count(),
            'trashed'   => Course::onlyTrashed()->count(),
            'featured'  => Course::where('is_featured', true)->count(),
        ];

        return view('admin.courses.index', compact('courses', 'categories', 'stats', 'sort', 'perPage'));
    }

    // =========================================================
    // CREATE
    // =========================================================

    public function create(): View
    {
        $this->authorize('create', Course::class);

        $categories = Course::availableCategories();
        $maxSortOrder = Course::max('sort_order') ?? 0;

        return view('admin.courses.create', compact('categories', 'maxSortOrder'));
    }

    // =========================================================
    // STORE
    // =========================================================

    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $this->authorize('create', Course::class);

        $validated = $request->validated();

        DB::transaction(function () use ($validated, $request) {
            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $validated['thumbnail'] = $request->file('thumbnail')
                    ->store('course-thumbnails', 'public');
            }

            // Sync is_active with status
            $validated['is_active'] = ($validated['status'] === 'published');

            $course = Course::create($validated);

            if ($course->status === 'published') {
                $students = User::where('role', 'student')->get();
                if ($students->isNotEmpty()) {
                    Notification::send($students, new NewCourseAvailable($course));
                }
            }
        });

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Kursus berhasil dibuat.');
    }

    // =========================================================
    // SHOW (Admin Preview Detail)
    // =========================================================

    public function show(Course $course): View
    {
        $this->authorize('view', $course);

        $course->loadCount('lessons')
               ->load(['lessons' => fn ($q) => $q->orderBy('sort_order')]);

        $studentsCount = $course->progress()
            ->whereNull('lesson_id')
            ->distinct('user_id')
            ->count('user_id');

        return view('admin.courses.show', compact('course', 'studentsCount'));
    }

    // =========================================================
    // EDIT
    // =========================================================

    public function edit(Course $course): View
    {
        $this->authorize('update', $course);

        $categories = Course::availableCategories();

        return view('admin.courses.edit', compact('course', 'categories'));
    }

    // =========================================================
    // UPDATE
    // =========================================================

    public function update(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        $this->authorize('update', $course);

        $validated = $request->validated();

        DB::transaction(function () use ($validated, $request, $course) {
            $wasPublished = $course->status === 'published';

            // Handle thumbnail
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail
                if ($course->thumbnail) {
                    Storage::disk('public')->delete($course->thumbnail);
                }
                $validated['thumbnail'] = $request->file('thumbnail')
                    ->store('course-thumbnails', 'public');
            } elseif ($request->boolean('remove_thumbnail') && $course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
                $validated['thumbnail'] = null;
            } else {
                // Keep existing
                unset($validated['thumbnail']);
            }

            unset($validated['remove_thumbnail']);

            // Sync is_active with status
            $validated['is_active'] = ($validated['status'] === 'published');

            $course->update($validated);

            if (! $wasPublished && $course->status === 'published') {
                $students = User::where('role', 'student')->get();
                if ($students->isNotEmpty()) {
                    Notification::send($students, new NewCourseAvailable($course));
                }
            }
        });

        return redirect()
            ->route('admin.courses.edit', $course)
            ->with('success', 'Kursus berhasil diperbarui.');
    }

    // =========================================================
    // DESTROY (Soft Delete)
    // =========================================================

    public function destroy(Course $course): RedirectResponse
    {
        $this->authorize('delete', $course);

        $course->delete();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', "Kursus \"{$course->title}\" berhasil dihapus.");
    }

    // =========================================================
    // RESTORE
    // =========================================================

    public function restore(int $id): RedirectResponse
    {
        $course = Course::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $course);

        $course->restore();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', "Kursus \"{$course->title}\" berhasil dipulihkan.");
    }

    // =========================================================
    // DUPLICATE
    // =========================================================

    public function duplicate(Course $course): RedirectResponse
    {
        $this->authorize('duplicate', $course);

        DB::transaction(function () use ($course) {
            $newSlug = Course::generateUniqueSlug($course->title . ' Copy');

            Course::create([
                'slug'              => $newSlug,
                'title'             => $course->title . ' (Copy)',
                'short_description' => $course->short_description,
                'description'       => $course->description,
                'icon'              => $course->icon,
                'color'             => $course->color,
                'category'          => $course->category,
                'thumbnail'         => null, // tidak ikut duplicate
                'difficulty'        => $course->difficulty,
                'total_lessons'     => 0,
                'total_xp'          => $course->total_xp,
                'estimated_minutes' => $course->estimated_minutes,
                'language'          => $course->language,
                'is_featured'       => false,
                'is_active'         => false,
                'sort_order'        => $course->sort_order + 1,
                'status'            => 'draft',
            ]);
        });

        return redirect()
            ->route('admin.courses.index')
            ->with('success', "Kursus \"{$course->title}\" berhasil diduplikasi.");
    }

    // =========================================================
    // TOGGLE STATUS (Quick Publish/Draft)
    // =========================================================

    public function toggleStatus(Request $request, Course $course): RedirectResponse
    {
        $this->authorize('update', $course);

        $request->validate([
            'status' => ['required', 'in:draft,published,archived'],
        ]);

        $wasPublished = $course->status === 'published';

        $course->update([
            'status'    => $request->input('status'),
            'is_active' => $request->input('status') === 'published',
        ]);

        if (! $wasPublished && $course->status === 'published') {
            $students = User::where('role', 'student')->get();
            if ($students->isNotEmpty()) {
                Notification::send($students, new NewCourseAvailable($course));
            }
        }

        $label = match ($request->input('status')) {
            'published' => 'dipublikasikan',
            'archived'  => 'diarsipkan',
            default     => 'disimpan sebagai draft',
        };

        return back()->with('success', "Kursus \"{$course->title}\" berhasil {$label}.");
    }

    // =========================================================
    // DELETE THUMBNAIL
    // =========================================================

    public function deleteThumbnail(Course $course): RedirectResponse
    {
        $this->authorize('update', $course);

        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
            $course->update(['thumbnail' => null]);
        }

        return back()->with('success', 'Thumbnail berhasil dihapus.');
    }

    // =========================================================
    // PREVIEW (redirect ke Student view)
    // =========================================================

    public function preview(Course $course): RedirectResponse
    {
        $this->authorize('preview', $course);

        return redirect()->route('courses.show', $course->slug);
    }
}
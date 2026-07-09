<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Panel admin: rekap aktivitas & skor quiz siswa.
 * Sumber data: tabel quiz_attempts (1 baris per siswa per soal).
 */
class QuizAttemptController extends Controller
{
    public function index(Request $request): View
    {
        // Rekap per siswa: total soal dikerjakan, benar, salah, total XP dari quiz.
        $perStudent = QuizAttempt::query()
            ->selectRaw('user_id,
                COUNT(*) as total_dikerjakan,
                SUM(CASE WHEN is_correct = true THEN 1 ELSE 0 END) as total_benar,
                SUM(CASE WHEN is_correct = false THEN 1 ELSE 0 END) as total_salah,
                SUM(xp_earned) as total_xp')
            ->when($request->filled('lesson_id'), fn ($q) => $q->where('lesson_id', $request->input('lesson_id')))
            ->groupBy('user_id')
            ->orderByDesc('total_xp')
            ->with('user:id,name,email')
            ->paginate(25)
            ->withQueryString();

        $lessons = Lesson::orderBy('title')->get(['id', 'title']);

        $stats = [
            'total_attempts' => QuizAttempt::count(),
            'total_students' => QuizAttempt::distinct('user_id')->count('user_id'),
            'total_xp'       => (int) QuizAttempt::sum('xp_earned'),
        ];

        return view('admin.quiz-attempts.index', compact('perStudent', 'lessons', 'stats'));
    }

    /**
     * Detail/review jawaban quiz milik 1 siswa: daftar tiap soal yang pernah
     * dikerjakan beserta status benar/salah, XP, dikelompokkan per pelajaran.
     */
    public function show(User $user, Request $request): View
    {
        $attempts = QuizAttempt::query()
            ->where('user_id', $user->id)
            ->with(['quiz:id,lesson_id,question,question_type,options,correct_answer,explanation,xp_reward', 'lesson:id,title'])
            ->when($request->filled('lesson_id'), fn ($q) => $q->where('lesson_id', $request->input('lesson_id')))
            ->orderByDesc('answered_at')
            ->get();

        // Kelompokkan per pelajaran supaya lebih mudah dibaca.
        $byLesson = $attempts->groupBy(fn (QuizAttempt $a) => $a->lesson->title ?? '(Tanpa Pelajaran)');

        $stats = [
            'total_dikerjakan' => $attempts->count(),
            'total_benar'      => $attempts->where('is_correct', true)->count(),
            'total_salah'      => $attempts->where('is_correct', false)->count(),
            'total_xp'         => (int) $attempts->sum('xp_earned'),
        ];

        $lessons = Lesson::whereIn('id', QuizAttempt::where('user_id', $user->id)->pluck('lesson_id')->unique())
            ->orderBy('title')
            ->get(['id', 'title']);

        return view('admin.quiz-attempts.show', compact('user', 'byLesson', 'stats', 'lessons'));
    }
}

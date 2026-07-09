<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Services\QuizService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Controller sisi siswa untuk menjelajahi & mengerjakan quiz.
 */
class StudentQuizController extends Controller
{
    public function __construct(
        protected QuizService $quizService
    ) {}

    public function index(): View
    {
        $lessons = Lesson::query()
            ->with('course:id,title,color,slug')
            ->withCount([
                'quizzes as quiz_count' => fn ($q) => $q->where('is_active', true),
                'quizzes as mc_count'   => fn ($q) => $q->where('is_active', true)->where('question_type', 'multiple_choice'),
                'quizzes as essay_count'=> fn ($q) => $q->where('is_active', true)
                    ->where(function ($sub) {
                        $sub->where('question_type', 'word_arrange')
                            ->orWhere(function ($sub2) {
                                $sub2->where('question_type', 'essay')->whereNotNull('options');
                            });
                    }),
            ])
            ->having('quiz_count', '>', 0)
            ->orderBy('title')
            ->get();

        return view('quiz.index', compact('lessons'));
    }

    public function lesson(Lesson $lesson): View
    {
        $lesson->load('course');

        $quizzes = $lesson->quizzes()
            ->active()
            ->orderBy('sort_order')
            ->get();

        abort_if($quizzes->isEmpty(), 404);

        $mcQuizzes    = $quizzes->filter(fn (Quiz $q) => $q->question_type === 'multiple_choice')->values();
        $essayQuizzes = $quizzes->filter(fn (Quiz $q) => $q->is_word_arrange)->values();

        $progress = $this->quizService->getQuizProgressForLesson(
            Auth::user(),
            $lesson,
            $mcQuizzes,
            $essayQuizzes
        );

        return view('quiz.lesson', compact('lesson', 'quizzes', 'mcQuizzes', 'essayQuizzes', 'progress'));
    }

    /**
     * Mode kerjakan soal berurutan (1 pelajaran + 1 tipe soal) dalam 1 halaman,
     * dengan progress bar + tombol Selanjutnya/Selesai.
     */
    public function play(Lesson $lesson, string $type): View
    {
        abort_unless(in_array($type, ['mc', 'essay'], true), 404);

        $lesson->load('course');

        $quizzes = $lesson->quizzes()->active()->orderBy('sort_order')->get();

        $quizzes = $type === 'mc'
            ? $quizzes->filter(fn (Quiz $q) => $q->question_type === 'multiple_choice')->values()
            : $quizzes->filter(fn (Quiz $q) => $q->is_word_arrange)->values();

        abort_if($quizzes->isEmpty(), 404);

        // Acak urutan opsi/word-bank tiap soal.
        $quizzes->each(function (Quiz $quiz) {
            if (is_array($quiz->options) && count($quiz->options)) {
                $shuffled = $quiz->options;
                shuffle($shuffled);
                $quiz->setAttribute('options', $shuffled);
            }
        });

        return view('quiz.play', compact('lesson', 'quizzes', 'type'));
    }

    public function show(Quiz $quiz, Request $request): View
    {
        abort_unless($quiz->is_active, 404);

        $quiz->load('lesson.course');

        $user = Auth::user();
        $attempt = $user
            ? QuizAttempt::where('user_id', $user->id)->where('quiz_id', $quiz->id)->first()
            : null;

        // Mode review: dibuka lewat link "Lihat Review" di halaman Hasil Quiz.
        $reviewMode = $request->boolean('review') && $attempt !== null;

        // Untuk tipe susun kata, acak urutan word bank.
        if (! $reviewMode && $quiz->is_word_arrange && is_array($quiz->options) && count($quiz->options)) {
            $shuffled = $quiz->options;
            shuffle($shuffled);
            $quiz->setAttribute('options', $shuffled);
        }

        // Untuk multiple choice, acak urutan opsi jawaban.
        if (! $reviewMode && $quiz->question_type === 'multiple_choice' && is_array($quiz->options) && count($quiz->options)) {
            $shuffled = $quiz->options;
            shuffle($shuffled);
            $quiz->setAttribute('options', $shuffled);
        }

        $resultType = $quiz->is_word_arrange ? 'essay' : 'mc';

        return view('quiz.show', compact('quiz', 'resultType', 'attempt', 'reviewMode'));
    }

    public function checkAnswer(Request $request, Quiz $quiz): JsonResponse
    {
        $validated = $request->validate([
            'answer' => ['required'], // array untuk susun kata, string untuk pilihan ganda
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $result = $this->quizService->checkAnswer($user, $quiz, $validated['answer']);

        if ($result === null) {
            return response()->json([
                'correct' => null,
                'message' => 'Jawaban akan diperiksa manual.',
            ]);
        }

        return response()->json([
            'correct'     => $result['correct'],
            'xp_reward'   => $result['xp_reward'],
            'explanation' => $result['explanation'],
        ]);
    }

    /**
     * Halaman ringkasan hasil: berapa soal benar/salah + total XP.
     */
    public function result(Lesson $lesson, string $type): View
    {
        abort_unless(in_array($type, ['mc', 'essay'], true), 404);

        $lesson->load('course');

        $quizzes = $lesson->quizzes()->active()->orderBy('sort_order')->get();

        $quizzes = $type === 'mc'
            ? $quizzes->filter(fn (Quiz $q) => $q->question_type === 'multiple_choice')->values()
            : $quizzes->filter(fn (Quiz $q) => $q->is_word_arrange)->values();

        abort_if($quizzes->isEmpty(), 404);

        $userId = Auth::id();

        $attempts = QuizAttempt::where('user_id', $userId)
            ->whereIn('quiz_id', $quizzes->pluck('id'))
            ->get()
            ->keyBy('quiz_id');

        $totalSoal    = $quizzes->count();
        $totalBenar   = $attempts->where('is_correct', true)->count();
        $totalSalah   = $attempts->where('is_correct', false)->count();
        $totalDijawab = $attempts->count();
        $totalXp      = (int) $attempts->sum('xp_earned');

        $rows = $quizzes->map(function (Quiz $quiz) use ($attempts) {
            $attempt = $attempts->get($quiz->id);

            return [
                'quiz'       => $quiz,
                'status'     => $attempt === null ? 'belum' : ($attempt->is_correct ? 'benar' : 'salah'),
                'xp_earned'  => $attempt->xp_earned ?? 0,
            ];
        });

        return view('quiz.result', [
            'lesson'       => $lesson,
            'type'         => $type,
            'rows'         => $rows,
            'totalSoal'    => $totalSoal,
            'totalBenar'   => $totalBenar,
            'totalSalah'   => $totalSalah,
            'totalDijawab' => $totalDijawab,
            'totalXp'      => $totalXp,
        ]);
    }
}

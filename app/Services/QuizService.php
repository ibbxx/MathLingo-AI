<?php

namespace App\Services;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Lesson;
use App\Models\QuizAttempt;
use Illuminate\Support\Collection;

class QuizService
{
    /**
     * Check student's answer, log the attempt, and award XP if correct.
     *
     * @param  User  $user
     * @param  Quiz  $quiz
     * @param  array|string  $submittedAnswer
     * @return array|null Null if manual grading is needed, or array with result details.
     */
    public function checkAnswer(User $user, Quiz $quiz, array|string $submittedAnswer): ?array
    {
        $isCorrect = $quiz->checkAnswer($submittedAnswer);

        // $isCorrect can be null for types requiring manual grading (e.g. legacy essay without word bank)
        if ($isCorrect === null) {
            return null;
        }

        $xpAwardedThisSubmit = 0;

        $existing = QuizAttempt::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->first();

        // XP is only awarded once per question — on the first correct attempt.
        // Re-answering (whether correct or wrong) does not yield additional XP.
        $alreadyEarnedXp = (bool) ($existing && ($existing->xp_earned > 0));

        if ($isCorrect && !$alreadyEarnedXp) {
            $xpAwardedThisSubmit = (int) $quiz->xp_reward;
        }

        QuizAttempt::updateOrCreate(
            ['user_id' => $user->id, 'quiz_id' => $quiz->id],
            [
                'lesson_id'     => $quiz->lesson_id,
                'is_correct'    => $isCorrect,
                'xp_earned'     => $alreadyEarnedXp ? $existing->xp_earned : $xpAwardedThisSubmit,
                'attempt_count' => ($existing->attempt_count ?? 0) + 1,
                'answered_at'   => now(),
            ]
        );

        if ($xpAwardedThisSubmit > 0) {
            $profile = $user->profile;
            if ($profile) {
                $profile->addXp($xpAwardedThisSubmit);
            }
        }

        return [
            'correct'     => $isCorrect,
            'xp_reward'   => $xpAwardedThisSubmit,
            'explanation' => $quiz->explanation,
        ];
    }

    /**
     * Get quiz progress statistics for a student in a specific lesson.
     *
     * @param  User  $user
     * @param  Lesson  $lesson
     * @param  Collection  $mcQuizzes
     * @param  Collection  $essayQuizzes
     * @return array
     */
    public function getQuizProgressForLesson(User $user, Lesson $lesson, Collection $mcQuizzes, Collection $essayQuizzes): array
    {
        $allIds = $mcQuizzes->pluck('id')->merge($essayQuizzes->pluck('id'));

        $attempts = QuizAttempt::where('user_id', $user->id)
            ->whereIn('quiz_id', $allIds)
            ->get()
            ->keyBy('quiz_id');

        $summarize = function (Collection $quizzes) use ($attempts) {
            $mine = $attempts->only($quizzes->pluck('id')->all());

            return [
                'answered' => $mine->count(),
                'total'    => $quizzes->count(),
                'correct'  => $mine->where('is_correct', true)->count(),
                'xp'       => (int) $mine->sum('xp_earned'),
            ];
        };

        return [
            'mc'    => $summarize($mcQuizzes),
            'essay' => $summarize($essayQuizzes),
        ];
    }
}

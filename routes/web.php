<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentLessonController;  
use App\Http\Controllers\StudentQuizController;  // ← TAMBAH INI
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AITutorController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\LearningReportController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\LessonController as AdminLessonController;
use App\Http\Controllers\Admin\VocabularyController as AdminVocabularyController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Admin\QuizAttemptController as AdminQuizAttemptController;
use App\Http\Controllers\Admin\AchievementController as AdminAchievementController;
use App\Http\Controllers\Admin\StatisticController as AdminStatisticController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

use Illuminate\Support\Facades\Route;

// ── Welcome ──────────────────────────────────────────────────────────────────
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// ════════════════════════════════════════════════════════════════════════════
// STUDENT PANEL
// ════════════════════════════════════════════════════════════════════════════
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [StudentDashboardController::class, 'index'])
    ->name('dashboard');

    // ── Courses ──────────────────────────────────────────────────────────
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');

    // ── Lessons (Student) ─────────────────────────────────────────────────
    // {lesson} = Lesson ID (integer, route model binding)
    Route::get('/courses/{slug}/lessons/{lesson}', [StudentLessonController::class, 'show'])->name('courses.lessons.show');

    // -- Quiz
    Route::get('/quiz', [StudentQuizController::class, 'index'])
    ->name('quiz.index');
    Route::get('/quiz/lesson/{lesson}', [StudentQuizController::class, 'lesson'])->name('quiz.lesson');
    Route::get('/quiz/lesson/{lesson}/play/{type}', [StudentQuizController::class, 'play'])->name('quiz.lesson.play');
    Route::get('/quiz/lesson/{lesson}/hasil/{type}', [StudentQuizController::class, 'result'])->name('quiz.lesson.result');
    Route::get('/quiz/{quiz}', [StudentQuizController::class, 'show'])->name('quiz.show');
    Route::post('/quiz/{quiz}/check-answer', [StudentQuizController::class, 'checkAnswer'])->name('quiz.check-answer');

    // Progress actions — tetap via POST, redirect ke lesson show atau course show
    Route::post('/courses/{slug}/favorite', [CourseController::class, 'toggleFavorite'])->name('courses.favorite');
    Route::post('/courses/{slug}/lessons/{lesson}/start', [CourseController::class, 'startLesson'])->name('courses.lessons.start');
    Route::post('/courses/{slug}/lessons/{lesson}/complete', [CourseController::class, 'completeLesson'])->name('courses.lessons.complete');

    // ── Achievements ──────────────────────────────────────────────────────
    Route::resource('achievements', AchievementController::class);

    // ── Certificates ─────────────────────────────────────────────────────
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/certificates/{certificate}', [CertificateController::class, 'show'])->name('certificates.show');
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');

    // ── Learning Report ──────────────────────────────────────────────────
    Route::get('/learning-report', [LearningReportController::class, 'index'])->name('learning-report.index');

    // ── AI Tutor ─────────────────────────────────────────────────────────
    Route::get('/ai-tutor', [AITutorController::class, 'index'])->name('ai-tutor.index');
    Route::post('/ai-tutor/conversation', [AITutorController::class, 'newConversation'])->name('ai-tutor.new');
    Route::post('/ai-tutor/send', [AITutorController::class, 'sendMessage'])->name('ai-tutor.send');
    Route::post('/ai-tutor/regenerate', [AITutorController::class, 'regenerate'])->name('ai-tutor.regenerate');
    Route::get('/ai-tutor/messages/{conversation}', [AITutorController::class, 'getMessages'])->name('ai-tutor.messages');
    Route::patch('/ai-tutor/conversation/{conversation}/rename', [AITutorController::class, 'rename'])->name('ai-tutor.rename');
    Route::delete('/ai-tutor/conversation/{conversation}', [AITutorController::class, 'destroy'])->name('ai-tutor.destroy');

    // ── Profile ───────────────────────────────────────────────────────────
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar.upload');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // ── Notifications ─────────────────────────────────────────────────────
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/latest', [NotificationController::class, 'latest'])->name('notifications.latest');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});

// ════════════════════════════════════════════════════════════════════════════
// ADMIN PANEL
// ════════════════════════════════════════════════════════════════════════════

Route::prefix('admin')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/', fn () => redirect()->route('admin.dashboard'));

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Users
        Route::resource('users', AdminUserController::class);
        Route::delete('/users/{user}/avatar', [AdminUserController::class, 'deleteAvatar'])->name('users.avatar.delete');
        Route::patch('/users/{user}/password', [AdminUserController::class, 'resetPassword'])->name('users.password.reset');
        Route::patch('/users/{user}/status', [AdminUserController::class, 'toggleStatus'])->name('users.status.toggle');

        // Courses
        Route::resource('courses', AdminCourseController::class);
        Route::post('/courses/{course}/restore', [AdminCourseController::class, 'restore'])->name('courses.restore');
        Route::post('/courses/{course}/duplicate', [AdminCourseController::class, 'duplicate'])->name('courses.duplicate');
        Route::patch('/courses/{course}/status', [AdminCourseController::class, 'toggleStatus'])->name('courses.toggle-status');
        Route::delete('/courses/{course}/thumbnail', [AdminCourseController::class, 'deleteThumbnail'])->name('courses.delete-thumbnail');
        Route::get('/courses/{course}/preview', [AdminCourseController::class, 'preview'])->name('courses.preview');

        // Lessons
        Route::post('/lessons/upload-image', [AdminLessonController::class, 'uploadContentImage'])->name('lessons.upload-image');
        Route::resource('lessons', AdminLessonController::class);

        // Vocabulary
        Route::resource('vocabulary', AdminVocabularyController::class)->except(['show']);

        // Quizzes
        Route::resource('quizzes', AdminQuizController::class)->except(['show']);

        // Aktivitas / Skor Quiz Siswa
        Route::get('/quiz-attempts', [AdminQuizAttemptController::class, 'index'])->name('quiz-attempts.index');
        Route::get('/quiz-attempts/{user}', [AdminQuizAttemptController::class, 'show'])->name('quiz-attempts.show');

        // Achievements
        Route::get('/achievements', [AdminAchievementController::class, 'index'])->name('achievements.index');

        // Notifications
        Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications', [AdminNotificationController::class, 'store'])->name('notifications.store');

        // Statistics
        Route::get('/statistics', [AdminStatisticController::class, 'index'])->name('statistics.index');

        // Settings
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');

        // Profile Admin
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile.index');
    });

require __DIR__ . '/auth.php';
<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\StudentProfile;
use App\Models\User;
use App\Models\Vocabulary;
use App\Support\PublicStorage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorageCleanupTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Mock disk default public / s3
        Storage::fake(PublicStorage::diskName());
    }

    public function test_lesson_deletion_cleans_up_images()
    {
        $disk = Storage::disk(PublicStorage::diskName());

        // Create course
        $course = Course::create([
            'title' => 'Test Course',
            'color' => '#123456',
            'category' => 'Algebra',
            'difficulty' => 'beginner',
        ]);

        // Create lesson with cover image and content with inline image
        $coverPath = 'lesson-images/cover.png';
        $inlinePath = 'lesson-content-images/inline.png';

        $disk->put($coverPath, 'dummy cover');
        $disk->put($inlinePath, 'dummy inline');

        $inlineUrl = PublicStorage::url($inlinePath);

        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Test Lesson',
            'image' => $coverPath,
            'content' => '<p>Content</p><img src="' . $inlineUrl . '">',
            'lesson_type' => 'vocabulary',
        ]);

        // Create vocabulary and quiz with images
        $vocabPath = 'vocabulary-images/vocab.png';
        $quizPath = 'quiz-images/quiz.png';

        $disk->put($vocabPath, 'dummy vocab');
        $disk->put($quizPath, 'dummy quiz');

        $vocab = Vocabulary::create([
            'lesson_id' => $lesson->id,
            'term' => 'Test Term',
            'image' => $vocabPath,
        ]);

        $quiz = Quiz::create([
            'lesson_id' => $lesson->id,
            'question' => 'Test Question',
            'correct_answer' => 'Test',
            'image' => $quizPath,
        ]);

        // Verify files exist
        $disk->assertExists($coverPath);
        $disk->assertExists($inlinePath);
        $disk->assertExists($vocabPath);
        $disk->assertExists($quizPath);

        // Delete lesson
        $lesson->delete();

        // Assert files are deleted
        $disk->assertMissing($coverPath);
        $disk->assertMissing($inlinePath);
        $disk->assertMissing($vocabPath);
        $disk->assertMissing($quizPath);
    }

    public function test_course_force_delete_cleans_up_thumbnail_and_lesson_images()
    {
        $disk = Storage::disk(PublicStorage::diskName());

        $thumbnailPath = 'course-thumbnails/thumb.png';
        $disk->put($thumbnailPath, 'dummy thumb');

        $course = Course::create([
            'title' => 'Test Course',
            'color' => '#123456',
            'category' => 'Algebra',
            'difficulty' => 'beginner',
            'thumbnail' => $thumbnailPath,
        ]);

        $coverPath = 'lesson-images/cover.png';
        $disk->put($coverPath, 'dummy cover');

        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Test Lesson',
            'image' => $coverPath,
            'lesson_type' => 'vocabulary',
        ]);

        $disk->assertExists($thumbnailPath);
        $disk->assertExists($coverPath);

        // Soft delete shouldn't delete the file
        $course->delete();
        $disk->assertExists($thumbnailPath);
        $disk->assertExists($coverPath);

        // Force delete should clean up everything
        $course->forceDelete();
        $disk->assertMissing($thumbnailPath);
        $disk->assertMissing($coverPath);
    }

    public function test_image_updates_clean_up_old_images()
    {
        $disk = Storage::disk(PublicStorage::diskName());

        $course = Course::create([
            'title' => 'Test Course',
            'color' => '#123456',
            'category' => 'Algebra',
            'difficulty' => 'beginner',
        ]);

        $oldThumbnailPath = 'course-thumbnails/old-thumb.png';
        $newThumbnailPath = 'course-thumbnails/new-thumb.png';
        $oldLessonPath = 'lesson-images/old-lesson.png';
        $newLessonPath = 'lesson-images/new-lesson.png';
        $oldQuizPath = 'quiz-images/old-quiz.png';
        $newQuizPath = 'quiz-images/new-quiz.png';
        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Test Lesson',
            'image' => $oldLessonPath,
            'lesson_type' => 'vocabulary',
        ]);

        $oldVocabPath = 'vocabulary-images/old-vocab.png';
        $newVocabPath = 'vocabulary-images/new-vocab.png';

        foreach ([$oldThumbnailPath, $newThumbnailPath, $oldLessonPath, $newLessonPath, $oldQuizPath, $newQuizPath, $oldVocabPath, $newVocabPath] as $path) {
            $disk->put($path, 'dummy');
        }

        $course->update(['thumbnail' => $oldThumbnailPath]);

        $quiz = Quiz::create([
            'lesson_id' => $lesson->id,
            'question' => 'Test Question',
            'correct_answer' => 'Test',
            'image' => $oldQuizPath,
        ]);

        $disk->put($oldVocabPath, 'old dummy');
        $disk->put($newVocabPath, 'new dummy');

        $vocab = Vocabulary::create([
            'lesson_id' => $lesson->id,
            'term' => 'Test Term',
            'image' => $oldVocabPath,
        ]);

        $disk->assertExists($oldVocabPath);

        $course->update(['thumbnail' => $newThumbnailPath]);
        $lesson->update(['image' => $newLessonPath]);
        $quiz->update(['image' => $newQuizPath]);
        $vocab->update(['image' => $newVocabPath]);

        $disk->assertMissing($oldThumbnailPath);
        $disk->assertMissing($oldLessonPath);
        $disk->assertMissing($oldQuizPath);
        $disk->assertMissing($oldVocabPath);

        $disk->assertExists($newThumbnailPath);
        $disk->assertExists($newLessonPath);
        $disk->assertExists($newQuizPath);
        $disk->assertExists($newVocabPath);
    }

    public function test_lesson_content_update_cleans_up_removed_inline_images()
    {
        $disk = Storage::disk(PublicStorage::diskName());

        $course = Course::create([
            'title' => 'Test Course',
            'color' => '#123456',
            'category' => 'Algebra',
            'difficulty' => 'beginner',
        ]);

        $removedDoubleQuotePath = 'lesson-content-images/removed-double.png';
        $removedSingleQuotePath = 'lesson-content-images/removed-single.png';
        $keptPath = 'lesson-content-images/kept.png';

        foreach ([$removedDoubleQuotePath, $removedSingleQuotePath, $keptPath] as $path) {
            $disk->put($path, 'dummy');
        }

        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Test Lesson',
            'content' => implode('', [
                '<p>Old content</p>',
                '<img src="/storage/' . $removedDoubleQuotePath . '?v=123">',
                "<img SRC='/storage/{$removedSingleQuotePath}'>",
                '<img src="' . PublicStorage::url($keptPath) . '">',
            ]),
            'lesson_type' => 'vocabulary',
        ]);

        $lesson->update([
            'content' => '<p>New content</p><img src="' . PublicStorage::url($keptPath) . '?v=456">',
        ]);

        $disk->assertMissing($removedDoubleQuotePath);
        $disk->assertMissing($removedSingleQuotePath);
        $disk->assertExists($keptPath);
    }

    public function test_student_profile_avatar_update_and_user_delete_clean_up_images()
    {
        $disk = Storage::disk(PublicStorage::diskName());

        $oldAvatarPath = 'avatars/old.png';
        $newAvatarPath = 'avatars/new.png';

        $disk->put($oldAvatarPath, 'old avatar');
        $disk->put($newAvatarPath, 'new avatar');

        $user = User::factory()->create();
        $profile = StudentProfile::create([
            'user_id' => $user->id,
            'avatar_url' => $oldAvatarPath,
        ]);

        $profile->update(['avatar_url' => $newAvatarPath]);

        $disk->assertMissing($oldAvatarPath);
        $disk->assertExists($newAvatarPath);

        $user->delete();

        $disk->assertMissing($newAvatarPath);
    }
}

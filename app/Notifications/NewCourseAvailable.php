<?php

namespace App\Notifications;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewCourseAvailable extends Notification
{
    use Queueable;

    public function __construct(protected Course $course)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'icon'    => 'book',
            'color'   => $this->course->color,
            'title'   => 'Kursus baru tersedia',
            'message' => "Kursus \"{$this->course->title}\" baru saja dipublikasikan. Yuk mulai belajar!",
            'url'     => route('courses.show', $this->course->slug),
        ];
    }
}

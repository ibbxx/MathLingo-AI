<?php

namespace App\Notifications;

use App\Models\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CertificateIssued extends Notification
{
    use Queueable;

    public function __construct(protected Certificate $certificate)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $course = $this->certificate->course;

        return [
            'icon'    => 'award',
            'color'   => '#F59E0B',
            'title'   => 'Selamat! Kursus selesai 🎉',
            'message' => "Kamu berhasil menyelesaikan \"{$course->title}\" dan mendapatkan sertifikat.",
            'url'     => route('certificates.show', $this->certificate->id),
        ];
    }
}

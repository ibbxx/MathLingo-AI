<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminAnnouncement extends Notification
{
    use Queueable;

    public function __construct(
        protected string $title,
        protected string $message,
        protected ?string $url = null,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'icon'    => 'megaphone',
            'color'   => '#2563EB',
            'title'   => $this->title,
            'message' => $this->message,
            'url'     => $this->url,
        ];
    }
}

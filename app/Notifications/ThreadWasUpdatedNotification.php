<?php

namespace App\Notifications;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Notifications\Notification;

class ThreadWasUpdatedNotification extends Notification
{
    public function __construct(
        protected Thread $thread,
        protected Reply $reply,
    )
    {
        //
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => $this->reply->owner->name . ' replied to ' . $this->thread->title,
            'link' => $this->reply->path(),
        ];
    }
}

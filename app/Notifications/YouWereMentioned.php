<?php

namespace App\Notifications;

use App\Models\Reply;
use Illuminate\Notifications\Notification;

class YouWereMentioned extends Notification
{
    public function __construct(protected Reply $reply)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => $this->reply->owner->name . ' mentioned you in ' . $this->reply->thread->title,
            'link' => $this->reply->path(),
        ];
    }
}

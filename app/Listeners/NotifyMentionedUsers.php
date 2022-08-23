<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
use App\Models\User;
use App\Notifications\YouWereMentioned;

class NotifyMentionedUsers
{
    public function handle(ThreadReceivedNewReply $event)
    {
        User::whereIn('name', $event->reply->mentionedUsers())
            ->get()
            ->each(fn ($user) => $user->notify(new YouWereMentioned($event->reply)));
    }
}

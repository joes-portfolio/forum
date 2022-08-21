<?php

namespace App\Models;

use App\Notifications\ThreadWasUpdatedNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThreadSubscription extends Model
{
    protected $fillable = [
        'user_id',
        'thread_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    public function notify(Reply $reply): void
    {
        $this->user->notify(new ThreadWasUpdatedNotification($this->thread, $reply));
    }
}

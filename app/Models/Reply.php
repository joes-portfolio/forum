<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reply extends Model
{
    use Favoritable;
    use RecordsActivity;

    protected $fillable = [
        'user_id',
        'body',
    ];

    protected $with = [
        'owner',
        'favorites',
    ];

    protected $appends = [
        'is_favorited'
    ];

    protected static function booted(): void
    {
        static::created(function (self $reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function (self $reply) {
            $reply->thread->decrement('replies_count');
        });
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    public function path(): string
    {
        return "{$this->thread->path()}#reply-{$this->id}";
    }

    public function wasJustPublished(): bool
    {
        return $this->created_at->gt(now()->subMinute());
    }
}

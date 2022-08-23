<?php

namespace App\Models;

use App\Events\ThreadReceivedNewReply;
use App\Filters\ThreadFilters;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thread extends Model
{
    use RecordsActivity;

    protected $fillable = [
        'body',
        'title',
        'channel_id',
        'user_id',
    ];

    protected $with = [
        'channel',
        'creator',
    ];

    protected static function booted(): void
    {
        static::deleting(function (self $thread) {
            $thread->replies->each->delete();
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class)
            ->with('owner')
            ->withCount('favorites');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function isSubscribedTo(): Attribute
    {
        return Attribute::get(function () {
            return $this->subscriptions()
                ->where('user_id', auth()->id())
                ->exists();
        });
    }

    public function scopeFilter(Builder $query, ThreadFilters $filters)
    {
        $filters->apply($query);
    }

    public function path(): string
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function addReply(array $attributes): Reply
    {
        $reply = $this->replies()->create($attributes);

        event(new ThreadReceivedNewReply($reply));

        return $reply;
    }

    public function subscribe(int $userId = null): void
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id(),
        ]);
    }

    public function unsubscribe(int $userId = null): void
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    public function hasUpdatesFor(User $user): bool
    {
        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }
}

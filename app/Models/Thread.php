<?php

namespace App\Models;

use App\Filters\ThreadFilters;
use Illuminate\Contracts\Database\Eloquent\Builder;
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
        static::addGlobalScope('replies_count', function (Builder $builder) {
            $builder->withCount('replies');
        });

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

    public function scopeFilter(Builder $query, ThreadFilters $filters)
    {
        $filters->apply($query);
    }

    public function path(): string
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function addReply(array $reply): void
    {
        $this->replies()->create($reply);
    }
}

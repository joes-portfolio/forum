<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thread extends Model
{
    protected $fillable = [
        'body',
        'title',
        'user_id',
    ];

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function path(): string
    {
        return "/threads/{$this->id}";
    }

    public function addReply(array $reply): void
    {
        $this->replies()->create($reply);
    }
}
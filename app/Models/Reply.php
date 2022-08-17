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
}

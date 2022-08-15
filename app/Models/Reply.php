<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Reply extends Model
{
    protected $fillable = [
        'user_id',
        'body',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite(int $userId): Favorite
    {
        return $this->favorites()
            ->updateOrCreate([
                'user_id' => $userId
            ]);
    }

    public function isFavorited(): bool
    {
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }
}

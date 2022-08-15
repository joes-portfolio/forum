<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Favoritable
{

    public function isFavorited(): bool
    {
        return (bool) $this->favorites->where('user_id', auth()->id())->count();
    }

    public function favorite(int $userId): Favorite
    {
        return $this->favorites()
            ->updateOrCreate([
                'user_id' => $userId
            ]);
    }

    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Favoritable
{
    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function isFavorited(): Attribute
    {
        return Attribute::get(function () {
            return (bool) $this->favorites->where('user_id', auth()->id())->count();
        });
    }

    public function favorite(): Favorite
    {
        return $this->favorites()
            ->updateOrCreate([
                'user_id' => auth()->id()
            ]);
    }

    public function unfavorite(): bool
    {
        return $this->favorites()
            ->where([
                'user_id' => auth()->id()
            ])
            ->delete();
    }
}

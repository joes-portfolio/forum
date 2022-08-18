<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Favoritable
{
    protected static function bootFavoritable(): void
    {
        static::deleting(function (self $model) {
            $model->favorites->each->delete();
        });
    }

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

    public function favorite(): void
    {
        $this->favorites()
            ->updateOrCreate([
                'user_id' => auth()->id()
            ]);
    }

    public function unfavorite(): void
    {
        $this->favorites()
            ->where([
                'user_id' => auth()->id()
            ])
            ->get()
            ->each
            ->delete();
    }
}

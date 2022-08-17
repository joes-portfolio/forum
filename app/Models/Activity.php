<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'type',
    ];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public static function feed(User $user, $take = 50): Collection
    {
        return static::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->take($take)
            ->get()
            ->groupBy(function (Activity $activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}

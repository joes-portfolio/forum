<?php

namespace App\Filters;

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ThreadFilters extends Filters
{
    protected array $filters = ['by', 'popular'];

    public function by(string $userName): Builder
    {
        $user = User::query()
            ->where('name', $userName)
            ->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    public function popular(): Builder
    {
        return $this->builder->reorder('replies_count', 'desc');
    }
}

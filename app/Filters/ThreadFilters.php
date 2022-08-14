<?php

namespace App\Filters;

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ThreadFilters extends Filters
{
    protected array $filters = ['by'];

    public function by(string $userName): Builder
    {
        $user = User::query()
            ->where('name', $userName)
            ->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public const UPDATE = 'update';

    public function update(User $user, User $model): bool
    {
        return $user->is($model);
    }
}

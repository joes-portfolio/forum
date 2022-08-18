<?php

namespace App\Policies;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ThreadPolicy
{
    use HandlesAuthorization;

    public const UPDATE = 'update';

    public function viewAny(User $user): bool
    {
    }

    public function view(User $user, Thread $thread): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Thread $thread): Response
    {
        return ($thread->user_id === $user->id)
            ? Response::allow()
            : Response::deny('Stop. You know better.');
    }

    public function delete(User $user, Thread $thread): bool
    {
    }

    public function restore(User $user, Thread $thread): bool
    {
    }

    public function forceDelete(User $user, Thread $thread): bool
    {
    }
}

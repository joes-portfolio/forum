<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class ReplyPolicy
{
    use HandlesAuthorization;

    public const UPDATE = 'update';

    public function create(User $user): Response
    {
        $lastReply = $user->fresh()->lastReply;

        if (! $lastReply) {
            return Response::allow();
        }

        return $lastReply->wasJustPublished()
            ? Response::denyWithStatus(
                SymfonyResponse::HTTP_TOO_MANY_REQUESTS,
                "You're posting too frequently. Relax."
            )
            : Response::allow();
    }

    public function update(User $user, Reply $reply): Response
    {
        return ($reply->user_id === $user->id)
            ? Response::allow()
            : Response::deny('Stop. You know better.');
    }
}

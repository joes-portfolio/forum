<?php

use Database\Factories\ReplyFactory;
use Database\Factories\UserFactory;

it('can fetch their most recent reply', function () {
    $user = create(UserFactory::new());
    $reply = create(ReplyFactory::new(['user_id' => $user->id]));

    expect($reply->id)
        ->toEqual($user->lastReply->id);
});

it('can return its avatar path', function () {
    $user = create(UserFactory::new());

    expect('/storage/avatars/default.png')
        ->toEqual($user->avatar_path);

    $user->avatar_path = 'avatars/avatar.png';

    expect('/storage/avatars/avatar.png')
        ->toEqual($user->avatar_path);
});

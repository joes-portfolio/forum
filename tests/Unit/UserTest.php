<?php

use Database\Factories\ReplyFactory;
use Database\Factories\UserFactory;

it('can fetch their most recent reply', function () {
    $user = create(UserFactory::new());
    $reply = create(ReplyFactory::new(['user_id' => $user->id]));

    expect($reply->id)
        ->toEqual($user->lastReply->id);
});

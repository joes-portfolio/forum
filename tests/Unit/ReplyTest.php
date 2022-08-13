<?php

use App\Models\User;
use Database\Factories\ReplyFactory;

it('has an owner', function () {
    $reply = ReplyFactory::new()->create();

    expect($reply->owner)->toBeInstanceOf(User::class);
});

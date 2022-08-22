<?php

use App\Models\User;
use Database\Factories\ReplyFactory;

it('has an owner', function () {
    $reply = ReplyFactory::new()->create();

    expect($reply->owner)->toBeInstanceOf(User::class);
});

it('knows if it was just published', function () {
    $reply = create(ReplyFactory::new());

    expect($reply->wasJustPublished())->toBeTrue();

    $reply->created_at = now()->subMonth();

    expect($reply->wasJustPublished())->toBeFalse();
});

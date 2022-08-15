<?php

use Database\Factories\ReplyFactory;

use function Pest\Laravel\post;

test('an unauthenticated user cannot favorite replies', function () {
    post('replies/1/favorites')
        ->assertRedirect('login');
});

test('an authenticated user can favorite replies', function () {
    signIn();

    $reply = create(ReplyFactory::new());

    post("/replies/{$reply->id}/favorites");

    expect($reply->favorites)
        ->toHaveCount(1);
});

test('an authenticated user can favorite a reply once', function () {
    signIn();

    $reply = create(ReplyFactory::new());

    post("/replies/{$reply->id}/favorites");

    post("/replies/{$reply->id}/favorites");

    expect($reply->favorites)
        ->toHaveCount(1);
});

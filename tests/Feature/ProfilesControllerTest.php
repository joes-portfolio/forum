<?php

use Database\Factories\ThreadFactory;
use Database\Factories\UserFactory;

use function Pest\Laravel\get;

it('displays a user profile', function () {
    $user = create(UserFactory::new());

    get("/profiles/$user->name")
        ->assertSee($user->name);
});

it('displays all threads of the user', function () {
    $user = create(UserFactory::new());
    $thread = create(ThreadFactory::new(['user_id' => $user->id]));

    get("/profiles/$user->name")
        ->assertSee($thread->title)
        ->assertSee($thread->body);
});

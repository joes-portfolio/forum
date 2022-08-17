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
    signIn();

    $thread = create(ThreadFactory::new(['user_id' => auth()->user()]));

    get("/profiles/" . auth()->user()->name)
        ->assertSee($thread->title)
        ->assertSee($thread->body);
});

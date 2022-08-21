<?php

use Database\Factories\ThreadFactory;

use function Pest\Laravel\delete;
use function Pest\Laravel\post;

test('unauthenticated user cannot subscribe to a thread', function () {
    $thread = create(ThreadFactory::new());

    post($thread->path() . '/subscriptions')
        ->assertRedirect('/login');
});

test('authenticated user can subscribe to a thread', function () {
    signIn();

    $thread = create(ThreadFactory::new());

    post($thread->path() . '/subscriptions');

    // expect(auth()->user()->notifications)
    //     ->toHaveCount(0);
    //
    // $thread->addReply([
    //     'user_id' => auth()->id(),
    //     'body' => 'hello',
    // ]);

    expect($thread->subscriptions)
        ->toHaveCount(1);
});

test('authenticated user can unsubscribe from a thread', function () {
    signIn();

    $thread = create(ThreadFactory::new());

    $thread->subscribe();

    delete($thread->path() . '/subscriptions');

    expect($thread->subscriptions)
        ->toHaveCount(0);
});

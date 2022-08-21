<?php

use Database\Factories\DatabaseNotificationFactory;
use Database\Factories\ThreadFactory;
use Database\Factories\UserFactory;

use function Pest\Laravel\getJson;
use function Pest\Laravel\patch;

beforeEach(function () {
    signIn();
});

test('a notification is created when a thread receives a new reply that is not by the current user', function () {
    $thread = create(ThreadFactory::new());

    $thread->subscribe(auth()->id());

    expect(auth()->user()->notifications)
        ->toHaveCount(0);

    $thread->addReply([
        'user_id' => auth()->id(),
        'body' => 'hello',
    ]);

    expect(auth()->user()->fresh()->notifications)
        ->toHaveCount(0);

    $thread->addReply([
        'user_id' => create(UserFactory::new())->id,
        'body' => 'hello',
    ]);

    expect(auth()->user()->fresh()->notifications)
        ->toHaveCount(1);
});

test('an authenticated user can fetch their unread notifications', function () {
    create(DatabaseNotificationFactory::new());

    $user = auth()->user();

    $response = getJson("/profiles/{$user->name}/notifications");

    expect($response->json())
        ->toHaveCount(1);
});

test('an authenticated user can mark a notification has read', function () {
    create(DatabaseNotificationFactory::new());

    $user = auth()->user();
    $notificationId = $user->unreadNotifications->first()->id;

    expect(auth()->user()->unreadNotifications)
        ->toHaveCount(1);

    patch("/profiles/{$user->name}/notifications/{$notificationId}");

    expect($user->fresh()->unreadNotifications)
        ->toHaveCount(0);
});

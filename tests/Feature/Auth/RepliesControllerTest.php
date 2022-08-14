<?php

use Database\Factories\ReplyFactory;
use Database\Factories\ThreadFactory;
use Database\Factories\UserFactory;
use Illuminate\Auth\AuthenticationException;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\withoutExceptionHandling;

test('unauthenticated users cannot participate in threads', function () {
    $thread = ThreadFactory::new()->create();
    $reply = ReplyFactory::new()->raw();

    post("{$thread->path()}/replies", $reply)
        ->assertRedirect('/login');
});

test('authenticated users can participate in threads', function () {
    $user = UserFactory::new()->create();
    $thread = ThreadFactory::new()->create();
    $reply = ReplyFactory::new()->raw();

    actingAs($user);

    post("{$thread->path()}/replies", $reply)
        ->assertRedirect($thread->path());

    get($thread->path())
        ->assertSee($reply['body']);
});

test('reply requires a body', function () {
    signIn();

    $thread = create(ThreadFactory::new());
    $reply = raw(ReplyFactory::new(['body' => null]));

    post("{$thread->path()}/replies", $reply)
        ->assertSessionHasErrors('body');
});

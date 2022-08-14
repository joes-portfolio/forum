<?php

use Database\Factories\ReplyFactory;
use Database\Factories\ThreadFactory;
use Database\Factories\UserFactory;

use Illuminate\Auth\AuthenticationException;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\withoutExceptionHandling;

beforeEach(function () {
    withoutExceptionHandling();
});

test('unauthenticated users cannot participate in threads', function () {
    $this->expectException(AuthenticationException::class);

    $thread = ThreadFactory::new()->create();
    $reply = ReplyFactory::new()->raw();

    post("/threads/{$thread->id}/replies", $reply)
        ->assertRedirect('/login');
});

test('authenticated users can participate in threads', function () {
    $user = UserFactory::new()->create();
    $thread = ThreadFactory::new()->create();
    $reply = ReplyFactory::new()->raw();

    actingAs($user);

    post("/threads/{$thread->id}/replies", $reply)
        ->assertRedirect($thread->path());

    get($thread->path())
        ->assertSee($reply['body']);
});

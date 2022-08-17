<?php

use App\Models\Reply;
use Database\Factories\ReplyFactory;
use Database\Factories\ThreadFactory;
use Database\Factories\UserFactory;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

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

test('unauthorized users cannot delete replies', function () {
    $reply = create(ReplyFactory::new());

    delete("/replies/{$reply->id}")
        ->assertRedirect('/login');

    signIn();

    delete("/replies/{$reply->id}")
        ->assertForbidden();
});

test('authorized users can delete replies', function () {
    signIn();

    $reply = create(ReplyFactory::new(['user_id' => auth()->id()]));

    delete("/replies/{$reply->id}")
        ->assertRedirect();

    assertDatabaseMissing((new Reply)->getTable(), [
        'id' => $reply->id,
        'user_id' => $reply->user_id,
    ]);
});

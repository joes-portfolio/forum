<?php

use App\Models\Thread;
use Database\Factories\ReplyFactory;
use Database\Factories\ThreadFactory;
use Database\Factories\UserFactory;

use Illuminate\Auth\AuthenticationException;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\withoutExceptionHandling;

beforeEach(function () {
    $this->thread = create(ThreadFactory::new());
});


test('a user can view all threads', function () {
    get('/threads')
        ->assertOk()
        ->assertSee($this->thread->title);
});

test('a user can read a thread', function () {
    get($this->thread->path())
        ->assertOk()
        ->assertSee($this->thread->title);
});

test('a user can read replies of a thread', function () {
    $reply = create(ReplyFactory::new(['thread_id' => $this->thread->id]));

    get($this->thread->path())
        ->assertOk()
        ->assertSee($reply->body);
});

test('authenticated user can create a thread', function () {
    withoutExceptionHandling();

    signIn(create(UserFactory::new(['email' => 'l@l.l'])));

    $thread = make(ThreadFactory::new());

    post('/threads', $thread->toArray())
        ->assertRedirect();

    assertDatabaseHas((new Thread)->getTable(), [
        'title' => $thread->title,
        'body' => $thread->body,
    ]);

    get($thread->path())
        ->assertSee($thread->title)
        ->assertSee($thread->body);
});

test('unauthenticated user cannot create a thread', function () {
    withoutExceptionHandling();

    $this->expectException(AuthenticationException::class);

    $thread = raw(ThreadFactory::new());

    post('/threads', $thread)
        ->assertRedirect('/login');

    assertDatabaseMissing((new Thread)->getTable(), [
        'title' => $thread->title,
        'body' => $thread->body,
    ]);
});

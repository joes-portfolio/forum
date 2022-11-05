<?php

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use Database\Factories\ChannelFactory;
use Database\Factories\ReplyFactory;
use Database\Factories\ThreadFactory;
use Database\Factories\UserFactory;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

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

test('authenticated user can create a thread', function () {
    signIn(create(UserFactory::new()));

    $thread = make(ThreadFactory::new());

    $response = post('/threads', $thread->toArray())
        ->assertRedirect();

    assertDatabaseHas((new Thread)->getTable(), [
        'title' => $thread->title,
        'body' => $thread->body,
    ]);

    get($response->headers->get('Location'))
        ->assertSee($thread->title)
        ->assertSee($thread->body);
});

test('unauthenticated user cannot create a thread', function () {
    get('/threads/create')
        ->assertRedirect('/login');

    $thread = raw(ThreadFactory::new());

    post('/threads', $thread)
        ->assertRedirect('/login');

    assertDatabaseMissing((new Thread)->getTable(), [
        'title' => $thread['title'],
        'body' => $thread['body'],
    ]);
});

test('a thread requires a title', function () {
    signIn();

    $thread = make(ThreadFactory::new(['title' => null]));

    post('/threads', $thread->toArray())
        ->assertSessionHasErrors('title');
});

test('a thread requires a body', function () {
    signIn();

    $thread = make(ThreadFactory::new(['body' => null]));

    post('/threads', $thread->toArray())
        ->assertSessionHasErrors('body');
});

test('a thread requires a valid channel', function () {
    ChannelFactory::new()->count(2)->create();

    signIn();

    $thread = make(ThreadFactory::new(['channel_id' => null]));

    post('/threads', $thread->toArray())
        ->assertSessionHasErrors('channel_id');

    $thread = make(ThreadFactory::new(['channel_id' => 999]));

    post('/threads', $thread->toArray())
        ->assertSessionHasErrors('channel_id');
});

test('a user can filter threads by channel', function () {
    $channel = create(ChannelFactory::new());
    $threadInChannel = create(ThreadFactory::new(['channel_id' => $channel->id]));
    $threadNotInChannel = create(ThreadFactory::new());

    get("/threads/{$channel->slug}")
        ->assertOk()
        ->assertSee($threadInChannel->name)
        ->assertDontSee($threadNotInChannel->name);
});

test('a user can filter threads by a username', function () {
    signIn(create(UserFactory::new(['name' => 'johnWick'])));

    $threadByJohn = create(ThreadFactory::new(['user_id' => auth()->id()]));
    $threadNotByJohn = create(ThreadFactory::new());

    get('/threads?by=johnWick')
        ->assertSee($threadByJohn->title)
        ->assertDontSee($threadNotByJohn->title);
});

test('a user can filter threads by popularity', function () {
    $threadWithTwoReplies = create(ThreadFactory::new());
    create(ReplyFactory::new(['thread_id' => $threadWithTwoReplies->id])->count(2));

    $threadWithThreeReplies = create(ThreadFactory::new());
    create(ReplyFactory::new(['thread_id' => $threadWithThreeReplies->id])->count(3));

    $threadWithZeroReplies = $this->thread;

    get('/threads?popular=1')
        ->assertOk()
        ->assertSeeInOrder([
            $threadWithThreeReplies->title,
            $threadWithTwoReplies->title,
            $threadWithZeroReplies->title,
        ]);
});

test('a user can filter threads that are unanswered', function () {
    $threadWithTwoReplies = create(ThreadFactory::new());
    create(ReplyFactory::new(['thread_id' => $threadWithTwoReplies->id])->count(2));

    $threadWithZeroReplies = $this->thread;

    get('/threads?unanswered=1')
        ->assertOk()
        ->assertSee($threadWithZeroReplies->title)
        ->assertDontSee($threadWithTwoReplies->title);
});

test('unauthorized users cannot delete threads', function () {
    $thread = create(ThreadFactory::new());

    delete($thread->path())
        ->assertRedirect('/login');

    assertDatabaseHas((new Thread)->getTable(), ['id' => $thread->id]);

    signIn();

    delete($thread->path())
        ->assertForbidden();

    assertDatabaseHas((new Thread)->getTable(), ['id' => $thread->id]);
});

test('authorized users can delete threads', function () {
    signIn();

    $thread = create(ThreadFactory::new(['user_id' => auth()->id()]));
    $reply = create(ReplyFactory::new(['thread_id' => $thread->id]));

    delete($thread->path())
        ->assertRedirect('/threads');

    assertDatabaseMissing((new Thread)->getTable(), ['id' => $thread->id]);
    assertDatabaseMissing((new Reply)->getTable(), ['id' => $reply->id]);
    assertDatabaseMissing((new Activity)->getTable(), [
        'subject_id' => $thread->id,
        'subject_type' => $thread::class,
    ]);
    assertDatabaseMissing((new Activity)->getTable(), [
        'subject_id' => $reply->id,
        'subject_type' => $reply::class,
    ]);
});

test('new users must confirm email before creating threads', function () {
    signIn(create(UserFactory::new(['email_verified_at' => null])));

    get('/threads/create')
        ->assertRedirect('/threads')
        ->assertSessionHas('alert');

    $thread = raw(ThreadFactory::new());

    post('/threads', $thread)
        ->assertUnauthorized();
});

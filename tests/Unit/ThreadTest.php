<?php

use App\Models\Channel;
use App\Models\Reply;
use App\Models\User;
use App\Notifications\ThreadWasUpdatedNotification;
use Database\Factories\ReplyFactory;
use Database\Factories\ThreadFactory;
use Database\Factories\UserFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\get;

beforeEach(function () {
    $this->thread = ThreadFactory::new()->create();
});

it('can return its url string path', function () {
    expect($this->thread->path())
        ->toEqual("/threads/{$this->thread->channel->slug}/{$this->thread->id}");
});

it('has a creator', function () {
    expect($this->thread->creator)
        ->toBeInstanceOf(User::class);
});

it('has replies', function () {
    ReplyFactory::new(['thread_id' => $this->thread->id])
        ->count(2)
        ->create();

    expect($this->thread->replies)
        ->toBeInstanceOf(Collection::class)
        ->and($this->thread->replies[0])->toBeInstanceOf(Reply::class)
        ->and($this->thread->replies[1])->toBeInstanceOf(Reply::class);
});

it('can add a reply', function () {
    $this->thread->addReply([
        'body' => 'foo bar',
        'user_id' => 1
    ]);

    expect($this->thread->replies)
        ->toHaveCount(1);
});

it("notifies it's subscribers when a new reply is added", function () {
    Notification::fake();

    signIn();

    $this->thread->subscribe();

    $this->thread->addReply([
        'body' => 'foo bar',
        'user_id' => create(UserFactory::new())->id,
    ]);

    Notification::assertSentTo(auth()->user(), ThreadWasUpdatedNotification::class);
});

it('belongs to a channel', function () {
    expect($this->thread->channel)
        ->toBeInstanceOf(Channel::class);
});

it('can be subscribed to', function () {
    $this->thread->subscribe($userId = 1);

    expect($this->thread->subscriptions()->where('user_id', $userId)->get())
        ->toHaveCount(1);
});

it('can be unsubscribed from', function () {
    $this->thread->subscribe($userId = 1);

    $this->thread->unsubscribe($userId);

    expect($this->thread->subscriptions()->where('user_id', $userId)->get())
        ->toHaveCount(0);
});

it('knows if the authenticated user is subscribed', function () {
    $thread = create(ThreadFactory::new());

    signIn();

    expect($thread->is_subscribed_to)->toBeFalse();

    $thread->subscribe();

    expect($thread->is_subscribed_to)->toBeTrue();
});

it("can check if authenticated users have viewed its latest updates", function () {
    signIn();

    $user = auth()->user();

    expect($this->thread->hasUpdatesFor($user))->toBeTrue();

    $user->read($this->thread);

    expect($this->thread->hasUpdatesFor($user))->toBeFalse();
});

it('increments its visits count when viewed', function () {
    $thread = create(ThreadFactory::new());

    expect($thread->visits_count)->toEqual(0);

    get($thread->path());

    expect($thread->fresh()->visits_count)->toEqual(1);
});

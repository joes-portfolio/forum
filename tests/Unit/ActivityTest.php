<?php

use App\Models\Activity;
use Database\Factories\ReplyFactory;
use Database\Factories\ThreadFactory;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

it('records activity when a thread is created', function () {
    signIn();

    $thread = create(ThreadFactory::new());

    assertDatabaseHas((new Activity)->getTable(), [
        'user_id' => auth()->id(),
        'type' => 'created_thread',
        'subject_id' => $thread->id,
        'subject_type' => $thread::class,
    ]);

    $activity = Activity::first();

    expect($activity->subject->id)->toBe($thread->id);
});

it('records activity when a reply is created', function () {
    signIn();

    $reply = create(ReplyFactory::new());

    assertDatabaseHas((new Activity)->getTable(), [
        'user_id' => auth()->id(),
        'type' => 'created_reply',
        'subject_id' => $reply->id,
        'subject_type' => $reply::class,
    ]);

    assertDatabaseCount((new Activity)->getTable(), 2);

    $activity = Activity::first();

    expect($activity->subject->id)->toBe($reply->id);
});

it('fetches the activity feed of a user', function () {
    signIn();

    create(
        ThreadFactory::new(['user_id' => auth()->id()])
            ->count(2)
    );

    auth()->user()->activity()->first()
        ->forceFill(['created_at' => now()->subWeek()])
        ->save();

    $feed = Activity::feed(auth()->user(), 50);

    expect($feed->keys())
        ->toContain(
            now()->format('Y-m-d'),
            now()->subWeek()->format('Y-m-d'),
        );
});

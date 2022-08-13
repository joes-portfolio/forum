<?php

use Database\Factories\ThreadFactory;

use function Pest\Laravel\get;

test('a user can view all threads', function () {
    $thread = ThreadFactory::new()->create();

    $response = get('/threads');

    $response->assertOk();
    $response->assertSee($thread->title);
});

test('a user can read a thread', function () {
    $thread = ThreadFactory::new()->create();

    $response = get("/threads/{$thread->id}");

    $response->assertOk();
    $response->assertSee($thread->title);
});

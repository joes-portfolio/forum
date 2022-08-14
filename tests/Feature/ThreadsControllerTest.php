<?php

use Database\Factories\{ReplyFactory, ThreadFactory};

use function Pest\Laravel\get;

beforeEach(function () {
    $this->thread = ThreadFactory::new()->create();
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
    $reply = ReplyFactory::new(['thread_id' => $this->thread->id])->create();

    get($this->thread->path())
        ->assertOk()
        ->assertSee($reply->body);
});

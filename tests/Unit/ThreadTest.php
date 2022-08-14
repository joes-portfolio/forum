<?php

use App\Models\Reply;
use App\Models\User;
use Database\Factories\ReplyFactory;
use Database\Factories\ThreadFactory;
use Illuminate\Support\Collection;

beforeEach(function () {
    $this->thread = ThreadFactory::new()->create();
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

it('has a creator', function () {
    expect($this->thread->creator)
        ->toBeInstanceOf(User::class);
});

it('can add a reply', function () {
    $this->thread->addReply([
        'body' => 'foo bar',
        'user_id' => 1
    ]);

    expect($this->thread->replies)
        ->toHaveCount(1);
});

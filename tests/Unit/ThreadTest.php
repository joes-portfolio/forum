<?php

use App\Models\Channel;
use App\Models\Reply;
use App\Models\User;
use Database\Factories\ReplyFactory;
use Database\Factories\ThreadFactory;
use Illuminate\Support\Collection;

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

it('belongs to a channel', function () {
    expect($this->thread->channel)
        ->toBeInstanceOf(Channel::class);
});

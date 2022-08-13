<?php

use App\Models\Reply;
use Database\Factories\{ReplyFactory, ThreadFactory};
use Illuminate\Support\Collection;

it('has replies', function () {
    $thread = ThreadFactory::new()->create();
    $replies = ReplyFactory::new(['thread_id' => $thread->id])
        ->count(2)
        ->create();

    expect($thread->replies)
        ->toBeInstanceOf(Collection::class)
        ->and($thread->replies[0])->toBeInstanceOf(Reply::class);
});

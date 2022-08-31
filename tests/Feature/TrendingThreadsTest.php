<?php

use Database\Factories\ThreadFactory;
use Illuminate\Support\Facades\Redis;

use function Pest\Laravel\get;

beforeEach(function () {
    $this->redis = Redis::client();
    $this->redis->del('trending_threads');
});

test('thread score increments on visit', function () {
    expect($this->redis->zRevRange('trending_threads', 0, -1))
        ->toBeEmpty();

    $thread = create(ThreadFactory::new());

    get($thread->path());

    $trending = $this->redis->zRevRange('trending_threads', 0, -1);

    expect($trending)
        ->toHaveCount(1)
        ->and(json_decode($trending[0])->title)
        ->toEqual($thread->title);
});

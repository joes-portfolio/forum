<?php

use Database\Factories\ChannelFactory;
use Database\Factories\ThreadFactory;

it('has threads', function () {
    $channel = create(ChannelFactory::new());
    $thread = create(ThreadFactory::new(['channel_id' => $channel->id]));

    expect($channel->threads->contains($thread))
        ->toBeTrue();
});

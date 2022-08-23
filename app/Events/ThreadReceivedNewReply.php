<?php

namespace App\Events;

use App\Models\Reply;
use Illuminate\Foundation\Events\Dispatchable;

class ThreadReceivedNewReply
{
    use Dispatchable;

    public function __construct(public Reply $reply) {}
}

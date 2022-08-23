<?php

use App\Models\User;
use Database\Factories\ReplyFactory;

it('has an owner', function () {
    $reply = ReplyFactory::new()->create();

    expect($reply->owner)->toBeInstanceOf(User::class);
});

it('knows if it was just published', function () {
    $reply = create(ReplyFactory::new());

    expect($reply->wasJustPublished())->toBeTrue();

    $reply->created_at = now()->subMonth();

    expect($reply->wasJustPublished())->toBeFalse();
});

it('can detect mentioned user in the body', function () {
    $reply = new \App\Models\Reply([
        'body' => '@elonmusk is meeting with @stevejobs today'
    ]);

    expect(['elonmusk', 'stevejobs'])
        ->toEqual($reply->mentionedUsers());
});

test('usernames mentioned in the body are linked to the profile', function ($body, $parsedBody) {
    $reply = new \App\Models\Reply([
        'body' => $body
    ]);

    expect($reply->body)
        ->toEqual($parsedBody);
})->with([
    [
        '@stevejobs vs @elon',
        '<a href="/profiles/stevejobs">@stevejobs</a> vs <a href="/profiles/elon">@elon</a>'
    ],
    [
        '@elon_',
        '<a href="/profiles/elon_">@elon_</a>'
    ],
    [
        '@steve-jobs',
        '<a href="/profiles/steve-jobs">@steve-jobs</a>'
    ],
]);

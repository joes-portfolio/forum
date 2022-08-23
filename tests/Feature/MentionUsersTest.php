<?php

use Database\Factories\ReplyFactory;
use Database\Factories\ThreadFactory;
use Database\Factories\UserFactory;

use function Pest\Laravel\getJson;
use function Pest\Laravel\post;

test('users mentioned in a reply are notified', function () {
    $john = create(UserFactory::new(['name' => 'john']));
    $jane = create(UserFactory::new(['name' => 'jane']));

    signIn($john);

    $thread = create(ThreadFactory::new());
    $reply = raw(ReplyFactory::new([
        'body' => 'hello @jane'
    ]));

    post($thread->path() . '/replies', $reply);

    expect($jane->notifications)
        ->toHaveCount(1);
});

it('can fetch mentioned user by the first characters of their name', function ($name) {
    signIn();

    create(UserFactory::new(['name' => $name]));
    create(UserFactory::new([]));

    $response = getJson('api/users?s=' . $name[0]);

    expect($response->json())
        ->toHaveCount(1)
        ->and($response->json()[0]['value'])
        ->toEqual($name);
})->with([
    'elon',
    'steve',
]);

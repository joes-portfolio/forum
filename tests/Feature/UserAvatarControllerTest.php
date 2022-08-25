<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\post;

test('unauthenticated users cannot add avatar')
    ->post('/api/users/1/avatar')
    ->assertRedirect('/login');

test('a valid avatar file must be provided', function () {
    signIn();

    $response = post('/api/users/' . auth()->id() . '/avatar', [
        'avatar' => 'not-an-image',
    ]);

    $response->assertRedirect()
        ->assertSessionHasErrors(['avatar']);
});

test('authenticated user can add an avatar to their profile', function () {
    Storage::fake();

    signIn();

    post('/api/users/' . auth()->user()->name . '/avatar', [
        'avatar' => $file = UploadedFile::fake()->image('avatar.png'),
    ]);

    expect(auth()->user()->avatar_path)
        ->toEqual('/storage/avatars/' . $file->hashName());

    Storage::disk('public')->assertExists('avatars/' . $file->hashName());
});

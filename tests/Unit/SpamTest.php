<?php

use App\Services\Spam\Spam;

beforeEach(function () {
    $this->spam = new Spam();
});

it('checks for invalid keywords', function ($text) {
    $this->expectException(Exception::class);

    $this->spam->detect($text);
})->with([
    'earn extra cash',
    'Double your cash',
    'Financial freedom',
]);

it('checks for held down keys', function () {
    $this->expectException(Exception::class);
    $this->spam->detect('I am nooooooooot a rooooobot');
});

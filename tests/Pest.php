<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;

uses(Tests\TestCase::class)->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Persist and return a model instance for a factory
 *
 * @return \Illuminate\Database\Eloquent\Model
 */
function create(Factory $factory)
{
    return $factory->create();
}

/**
 * Return a model instance for a factory
 *
 * @return \Illuminate\Database\Eloquent\Model
 */
function make(Factory $factory)
{
    return $factory->make();
}

/**
 * Return a raw model attributes for a factory
 *
 * @return \Illuminate\Database\Eloquent\Model
 */
function raw(Factory $factory)
{
    return $factory->raw();
}

/**
 * Set the currently logged-in user for the application.
 *
 * @return TestCase
 */
function signIn(Authenticatable $user = null)
{
    $user ??= create(\Database\Factories\UserFactory::new());

    return test()->actingAs($user);
}

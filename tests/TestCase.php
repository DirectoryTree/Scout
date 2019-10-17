<?php

namespace Tests;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Sign a user in.
     *
     * @param User|null $user
     *
     * @return User
     */
    protected function signIn(User $user = null)
    {
        $user = $user ?? factory(User::class)->create();

        Auth::login($user);

        return $user;
    }

    /**
     * Use a custom test response base.
     *
     * @param \Illuminate\Http\Response $response
     *
     * @return TestResponse
     */
    protected function createTestResponse($response)
    {
        return TestResponse::fromBaseResponse($response);
    }
}

<?php

namespace Tests;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn(User $user = null)
    {
        Auth::login($user ?? factory(User::class)->create());
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

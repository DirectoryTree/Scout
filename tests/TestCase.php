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
}

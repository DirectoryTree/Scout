<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Arr;

class SetupTest extends TestCase
{
    public function test_user_is_redirected_upon_first_visit()
    {
        $this->get('/')->assertRedirect(route('login'));

        $this->followingRedirects()->get('/')
            ->assertSee('Welcome')
            ->assertSee('Thanks for installing Scout')
            ->assertSee('Register');
    }

    public function test_user_can_setup_administrator()
    {
        $this->get(route('register'))
            ->assertSee('Create an Administrator Account');

        $data = [
            'name' => 'User',
            'email' => 'test@email.com',
            'password' => 'super-secret',
            'password_confirmation' => 'super-secret',
        ];

        $this->post(route('register'), $data)
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertDatabaseHas('users', Arr::only($data, ['name', 'email']));
    }

    public function test_new_user_requires_minimum_eight_character_password()
    {
        $data = [
            'name' => 'User',
            'email' => 'test@email.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $this->post(route('register'), $data)
            ->assertSessionHasErrors('password')
            ->assertRedirect();
    }

    public function test_new_user_requires_confirmed_password()
    {
        $data = [
            'name' => 'User',
            'email' => 'test@email.com',
            'password' => 'super-secret',
        ];

        $this->post(route('register'), $data)
            ->assertSessionHasErrors('password')
            ->assertRedirect();
    }

    public function test_new_user_requires_valid_email()
    {
        $data = [
            'name' => 'User',
            'email' => 'invalid-email',
            'password' => 'super-secret',
            'password_confirmation' => 'super-secret',
        ];

        $this->post(route('register'), $data)
            ->assertSessionHasErrors('email')
            ->assertRedirect();
    }

    public function test_registered_user_does_not_see_setup_welcome()
    {
        $this->signIn();

        $this->get('/')
            ->assertDontSee('Thanks for installing Scout')
            ->assertDontSee('Register');
    }
}

<?php

namespace App\Http\Controllers\Settings;

use App\User;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * View all application users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();

        return view('settings.users.index', compact('users'));
    }

    /**
     * Display the form for editing the user.
     *
     * @param User $user
     *
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('settings.users.edit', compact('user'));
    }

    public function update(User $user)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Settings;

use App\User;
use App\Scout;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\UserUpdateRequest;
use App\Http\Requests\Setting\UserCreationRequest;

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
     * Display the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('settings.users.create');
    }

    /**
     * Creates a new user.
     *
     * @param UserCreationRequest $request
     *
     * @return \App\Http\ScoutResponse
     */
    public function store(UserCreationRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return Scout::response()
            ->redirect(route('settings.users.index'))
            ->notifyWithMessage('Added user.');
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

    /**
     * Updates the user.
     *
     * @param UserUpdateRequest $request
     * @param User              $user
     *
     * @return \App\Http\ScoutResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return Scout::response()
            ->notifyWithMessage('Updated user.');
    }

    /**
     * Delete a user.
     *
     * @param User $user
     *
     * @return \App\Http\ScoutResponse
     *
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        if ($user->is(auth()->user())) {
            return Scout::response()
                ->type('warning')
                ->notifyWithMessage('You cannot delete yourself.');
        }

        $user->delete();

        return Scout::response()
            ->redirect(route('settings.users.index'))
            ->notifyWithMessage('Deleted user.');
    }
}

<?php

namespace App\Http\Injectors;

use Illuminate\Http\Request;

class NotificationInjector
{
    /**
     * The current user.
     *
     * @var \App\User
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->user = $request->user();
    }

    /**
     * Get the current users last 10 unread notifications.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        return $this->user->unreadNotifications()->limit(10)->get();
    }
}

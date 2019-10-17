<?php

namespace App;

use Illuminate\Notifications\DatabaseNotification;

class Notifications
{
    /**
     * @var User
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the users last 10 notifications.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        return DatabaseNotification::with('notifiable')
            ->limit(10)
            ->get();
    }
}

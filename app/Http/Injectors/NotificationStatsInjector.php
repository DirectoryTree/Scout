<?php

namespace App\Http\Injectors;

class NotificationStatsInjector
{
    /**
     * The logged in user.
     *
     * @var \App\User
     */
    protected $user;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * Get the number of read notifications.
     *
     * @return int
     */
    public function getReadCount()
    {
        return $this->user->readNotifications()->count();
    }

    /**
     * Get the number of unread notifications.
     *
     * @return int
     */
    public function getUnreadCount()
    {
        return $this->user->unreadNotifications()->count();
    }
}

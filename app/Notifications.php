<?php

namespace App;

use App\Http\Resources\Notifications as NotificationResource;

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
        return $this->user->notifications()
            ->with('notifiable')
            ->limit(10)
            ->get();
    }

    /**
     * Get the users notifications as a resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function resource()
    {
        return NotificationResource::collection($this->get());
    }
}

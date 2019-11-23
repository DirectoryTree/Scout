<?php

namespace App\Http\Injectors;

use App\LdapObject;
use App\LdapNotifier;
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
        $latestNotifications = $this->user->lastUnreadNotifications()->get();

        $notifiers = LdapNotifier::find($latestNotifications->pluck('data.notifier_id'));
        $objects = LdapObject::with('domain')->find($latestNotifications->pluck('data.object_id'));

        // Here we must
        return $latestNotifications
            ->whereIn('data.object_id', $objects->map->id)
            ->whereIn('data.notifier_id', $notifiers->map->id)
            ->transform(function ($notification) use ($objects, $notifiers) {
                $notifierId = data_get($notification->data, 'notifier_id');
                $objectId = data_get($notification->data, 'object_id');

                $notification->object = $objects->firstWhere('id', $objectId);
                $notification->notifier = $notifiers->firstWhere('id', $notifierId);

                return $notification;
            });
    }
}

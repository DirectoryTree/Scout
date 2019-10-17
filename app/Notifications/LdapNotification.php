<?php

namespace App\Notifications;

use App\LdapObject;
use App\LdapNotifier;
use App\Http\Resources\LdapObject as LdapObjectResource;
use App\Http\Resources\LdapNotifier as LdapNotifierResource;
use Illuminate\Notifications\Notification;

class LdapNotification extends Notification
{
    /**
     * @var LdapNotifier
     */
    protected $notifier;

    /**
     * @var LdapObject
     */
    protected $object;

    /**
     * Constructor.
     *
     * @param LdapNotifier $notifier
     * @param LdapObject   $object
     */
    public function __construct(LdapNotifier $notifier, LdapObject $object)
    {
        $this->notifier = $notifier;
        $this->object = $object;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * Returns the modified attributes names.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'object' => LdapObjectResource::make($this->object),
            'notifier' => LdapNotifierResource::make($this->notifier),
        ];
    }
}

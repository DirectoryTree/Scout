<?php

namespace App\Notifications;

use App\LdapObject;
use App\LdapNotifier;
use Illuminate\Notifications\Notification;

class LdapNotification extends Notification
{
    /**
     * @var LdapObject
     */
    protected $object;

    /**
     * @var LdapNotifier
     */
    protected $notifier;

    /**
     * Constructor.
     *
     * @param LdapObject   $object
     * @param LdapNotifier $notifier
     */
    public function __construct(LdapObject $object, LdapNotifier $notifier)
    {
        $this->object = $object;
        $this->notifier = $notifier;
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
            'name' => $this->notifier->name,
        ];
    }
}

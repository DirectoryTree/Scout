<?php

namespace App\Notifications;

use App\LdapObject;
use App\LdapNotifier;
use Illuminate\Notifications\Notification;

class LdapNotification extends Notification
{
    /**
     * @var LdapNotifier
     */
    protected $notifier;

    /**
     * Constructor.
     *
     * @param LdapNotifier $notifier
     */
    public function __construct(LdapNotifier $notifier)
    {
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
     * @param LdapObject $notifiable
     *
     * @return array
     */
    public function toArray(LdapObject $notifiable)
    {
        return [
            'name' => $this->notifier->notifiable_name,
        ];
    }
}

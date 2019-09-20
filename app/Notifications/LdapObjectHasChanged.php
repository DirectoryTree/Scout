<?php

namespace App\Notifications;

use App\LdapChange;
use App\LdapObject;
use Illuminate\Notifications\Notification;

class LdapObjectHasChanged extends Notification
{
    /**
     * @var LdapChange
     */
    protected $change;

    /**
     * Constructor.
     *
     * @param LdapChange $change
     */
    public function __construct(LdapChange $change)
    {
        $this->change = $change;
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
            'change_id' => $this->change->id,
            'object' => $notifiable->toArray(),
            'modified' => array_keys($this->change->attributes),
        ];
    }
}

<?php

namespace App\Notifications;

use App\LdapChange;
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
            'change_id' => $this->change->id,
            'attribute' => $this->change->attribute,
            'before' => $this->change->before,
            'after' => $this->change->after,
        ];
    }
}

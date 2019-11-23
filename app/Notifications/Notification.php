<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification as BaseNotification;

abstract class Notification extends BaseNotification implements ScoutNotification
{
    /**
     * {@inheritDoc}
     */
    public function getType()
    {
        return 'success';
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
            'name' => $this->getName(),
            'title' => $this->getTitle(),
            'body' => $this->getBody(),
            'type' => $this->getType(),
        ];
    }
}

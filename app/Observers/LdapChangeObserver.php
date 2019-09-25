<?php

namespace App\Observers;

use App\LdapChange;
use App\LdapNotification;
use App\Notifications\LdapObjectHasChanged;

class LdapChangeObserver
{
    /**
     * Fire the relevant events upon LDAP change creation.
     *
     * @param LdapChange $change
     */
    public function created(LdapChange $change)
    {
        logger("Change: {$change->getKey()} created.");

        LdapNotification::where('attribute', '=', $change->attribute)
            ->get()
            ->each(function (LdapNotification $notification) use ($change) {
                if (($notifiable = $notification->notifiable) && $this->isNotifiable($notifiable)) {
                    $notifiable->notify(new LdapObjectHasChanged($change));
                }
            });
    }

    /**
     * Determine if the given model is notifiable.
     *
     * @param mixed $notifiable
     *
     * @return bool
     */
    protected function isNotifiable($notifiable)
    {
        return method_exists($notifiable, 'notify');
    }
}

<?php

namespace App\Observers;

use App\LdapChange;
use App\LdapNotifier;
use App\Ldap\Conditions\Validator;
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

        // Here we will retrieve all the notifiers that contain conditions for the changed attribute.
        $this->getNotifiersForAttribute($change->attribute)->each(function (LdapNotifier $notification) use ($change) {
            if (
                ($notifiable = $notification->notifiable) &&
                $this->isNotifiable($notifiable) &&
                $this->passesConditions($notification->conditions, $change)
            ) {
                $notifiable->notify(new LdapObjectHasChanged($change));
            }
        });
    }

    /**
     * Get the LDAP notifiers for the changes attribute.
     *
     * @param string $attribute
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getNotifiersForAttribute($attribute)
    {
        return LdapNotifier::query()->whereHas('conditions', function ($query) use ($attribute) {
            return $query->where('attribute', '=', $attribute);
        })->with('conditions')->get();
    }

    /**
     * Determine if all of the notifier conditions pass.
     *
     * @param \Illuminate\Support\Collection $conditions
     * @param LdapChange                     $change
     *
     * @return bool
     */
    protected function passesConditions($conditions, LdapChange $change)
    {
        return (new Validator($conditions, $change->after ?? []))->passes();
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

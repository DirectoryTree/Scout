<?php

namespace App\Observers;

use App\LdapObject;
use App\LdapNotifier;
use App\Ldap\Conditions\Validator;
use App\Notifications\LdapNotification;

class LdapObjectObserver
{
    /**
     * Handle the LDAP object "updated" event.
     *
     * @param LdapObject $object
     */
    public function updated(LdapObject $object)
    {
        // Here we will retrieve all the notifiers that contain conditions for the
        // objects attributes, determine if the notifiable model can be notified
        // and if all the conditions pass for the notifier conditions.
        $this->getNotifiersForAttributes($object->attributes)->each(function (LdapNotifier $notifier) use ($object) {
            if (
                ($notifiable = $notifier->notifiable) &&
                $this->isNotifiable($notifiable) &&
                $this->passesConditions($notifier->conditions, $object)
            ) {
                $notifiable->notify(new LdapNotification($object, $notifier));
            }
        });
    }

    /**
     * Get the LDAP notifiers for the given attributes.
     *
     * @param array $attributes
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getNotifiersForAttributes(array $attributes)
    {
        return LdapNotifier::query()->whereHas('conditions', function ($query) use ($attributes) {
            return $query->whereIn('attribute', $attributes);
        })->with('conditions')->get();
    }

    /**
     * Determine if all of the notifier conditions pass.
     *
     * @param \Illuminate\Support\Collection $conditions
     * @param LdapObject                     $object
     *
     * @return bool
     */
    protected function passesConditions($conditions, LdapObject $object)
    {
        return (new Validator($conditions, $object->after ?? []))->passes();
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

<?php

namespace App\Observers;

use App\User;
use App\LdapObject;
use App\LdapNotifier;
use App\LdapNotifierLog;
use Illuminate\Support\Arr;
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
        $attributes = array_keys($object->values);

        // Here we will retrieve all the notifiers that contain conditions for the
        // objects attributes, determine if the notifiable model can be notified
        // and if all the conditions pass for the notifier conditions.
        $this->getNotifiersForAttributes($attributes)->each(function (LdapNotifier $notifier) use ($object) {
            if ($this->passesConditions($notifier->conditions, $object)) {
                $this->createNotifierLogs($notifier, $object);

                $notification = new LdapNotification($notifier, $object);

                $users = $notifier->all_users ? User::all() : $notifier->users()->get();

                /** @var User $user */
                foreach ($users as $user) {
                    $user->notify($notification);
                }
            }
        });
    }

    /**
     * Create the notifier logs.
     *
     * @param LdapNotifier $notifier
     * @param LdapObject   $object
     *
     * @return \Illuminate\Support\Collection
     */
    protected function createNotifierLogs(LdapNotifier $notifier, LdapObject $object)
    {
        $logs = collect();

        $notifier->conditions->pluck('attribute')->each(function ($attribute) use ($notifier, $object, $logs) {
            $log = new LdapNotifierLog();

            $log->object()->associate($object);
            $log->notifier()->associate($notifier);

            $log->before = $this->getOriginalValue($object, $attribute);
            $log->after = $this->getUpdatedValue($object, $attribute);

            $log->save();

            $logs->add($log);
        });

        return $logs;
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
        return LdapNotifier::enabled()->whereHas('conditions', function ($query) use ($attributes) {
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
        return (new Validator(
            $conditions,
            $this->getUpdatedValues($object),
            $this->getOriginalValues($object)
        ))->passes();
    }

    /**
     * Get the LDAP objects original value for the attribute.
     *
     * @param LdapObject $object
     * @param string     $key
     *
     * @return mixed
     */
    protected function getOriginalValue(LdapObject $object, $key)
    {
        return Arr::get($this->getOriginalValues($object), $key);
    }

    /**
     * Get the LDAP objects updated value for the attribute.
     *
     * @param LdapObject $object
     * @param string     $key
     *
     * @return mixed
     */
    protected function getUpdatedValue(LdapObject $object, $key)
    {
        return Arr::get($this->getUpdatedValues($object), $key);
    }

    /**
     * Get the LDAP objects original values.
     *
     * @param LdapObject $object
     *
     * @return array
     */
    protected function getOriginalValues(LdapObject $object)
    {
        return json_decode($object->getOriginal('values'), true);
    }

    /**
     * Get the LDAP objects updated values.
     *
     * @param LdapObject $object
     *
     * @return array
     */
    protected function getUpdatedValues(LdapObject $object)
    {
        return $object->getAttribute('values');
    }
}

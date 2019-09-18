<?php

namespace App\Observers;

use App\LdapChange;
use Illuminate\Support\Facades\Event;

class LdapChangeObserver
{
    /**
     * The event mapping for directory changes.
     *
     * @var array
     */
    protected $events = [
        'member' => \App\Events\Ldap\GroupMembershipsChanged::class,
        'memberof' => \App\Events\Ldap\UserMembershipsChanged::class,
        'lastlogontimestamp' => \App\Events\Ldap\LoginOccurred::class,
    ];

    /**
     * Fire the relevant events upon LDAP change creation.
     *
     * @param LdapChange $change
     */
    public function created(LdapChange $change)
    {
        logger("Change: {$change->getKey()} created.");

        // Determine the events to fire depending on the changes.
        $events = array_intersect_key($this->events, $change->attributes ?? []);

        foreach ($events as $attribute => $event) {
            logger("Event: $event is being fired.");

            // Dispatch the relevant event from the map.
            Event::dispatch(new $event($change, $change->object, $attribute));
        }
    }
}

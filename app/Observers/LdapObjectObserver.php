<?php

namespace App\Observers;

use App\LdapObject;
use App\Jobs\GenerateLdapNotifications;

class LdapObjectObserver
{
    /**
     * Handle the LDAP object "updated" event.
     *
     * @param LdapObject $object
     */
    public function updated(LdapObject $object)
    {
        GenerateLdapNotifications::dispatch(
            $object,
            $this->getOriginalValues($object),
            $this->getUpdatedValues($object)
        );
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

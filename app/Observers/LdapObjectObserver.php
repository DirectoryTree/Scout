<?php

namespace App\Observers;

use App\LdapObject;
use App\Jobs\GenerateLdapNotifications;
use Illuminate\Support\Facades\Bus;

class LdapObjectObserver
{
    /**
     * Handle the LDAP object "updated" event.
     *
     * @param LdapObject $object
     */
    public function updated(LdapObject $object)
    {
        Bus::dispatch(new GenerateLdapNotifications($object));
    }
}

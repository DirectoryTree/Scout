<?php

namespace App\Http\Controllers;

use App\Scout;
use App\LdapObject;

class ObjectPinController extends Controller
{
    /**
     * Pin an LDAP object.
     *
     * @param LdapObject $object
     *
     * @return \App\Http\ScoutResponse
     */
    public function store(LdapObject $object)
    {
        $object->pinned = true;
        $object->save();

        return Scout::response()
            ->type('success')
            ->notifyWithMessage('Pinned.');
    }

    /**
     * Unpin an LDAP object.
     *
     * @param LdapObject $object
     *
     * @return \App\Http\ScoutResponse
     */
    public function destroy(LdapObject $object)
    {
        $object->pinned = false;
        $object->save();

        return Scout::response()
            ->type('success')
            ->notifyWithMessage('Unpinned.');
    }
}

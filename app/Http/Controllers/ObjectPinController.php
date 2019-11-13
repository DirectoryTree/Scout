<?php

namespace App\Http\Controllers;

use App\Scout;
use App\LdapObject;
use Illuminate\Http\Request;

class ObjectPinController extends Controller
{
    /**
     * Pin an LDAP object.
     *
     * @param Request    $request
     * @param LdapObject $object
     *
     * @return \App\Http\ScoutResponse
     */
    public function store(Request $request, LdapObject $object)
    {
        /** @var \App\User $user */
        $user = $request->user();

        $user->pins()->attach($object);

        return Scout::response()
            ->type('success')
            ->notifyWithMessage('Pinned.');
    }

    /**
     * Unpin an LDAP object.
     *
     * @param Request    $request
     * @param LdapObject $object
     *
     * @return \App\Http\ScoutResponse
     */
    public function destroy(Request $request, LdapObject $object)
    {
        /** @var \App\User $user */
        $user = $request->user();

        $user->pins()->detach($object);

        return Scout::response()
            ->type('success')
            ->notifyWithMessage('Unpinned.');
    }
}

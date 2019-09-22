<?php

namespace App\Http\Controllers;

use App\LdapDomain;

class DomainObjectAttributesController extends Controller
{
    /**
     * Displays the LDAP objects attributes.
     *
     * @param LdapDomain $domain
     * @param int        $objectId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(LdapDomain $domain, $objectId)
    {
        $object = $domain->objects()->findOrFail($objectId);

        return view('domains.objects.attributes.index', compact('domain', 'object'));
    }
}

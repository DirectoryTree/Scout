<?php

namespace App\Http\Controllers;

use App\LdapDomain;
use App\Ldap\Transformers\AttributeTransformer;

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
        $object = $domain->objects()->withTrashed()->findOrFail($objectId);

        $attributes = (new AttributeTransformer($object->values))->transform();

        return view('domains.objects.attributes.index', compact('domain', 'object', 'attributes'));
    }
}

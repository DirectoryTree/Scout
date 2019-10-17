<?php

namespace App\Http\Controllers\Api;

use App\LdapDomain;
use App\Ldap\Transformers\AttributeTransformer;

class DomainObjectAttributesController
{
    /**
     * Returns an HTML partial of the objects attributes.
     *
     * @param LdapDomain $domain
     * @param string     $objectId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(LdapDomain $domain, $objectId)
    {
        $object = $domain->objects()->withTrashed()->findOrFail($objectId);

        $attributes = (new AttributeTransformer($object->values))->transform();

        return view('domains.objects.attributes.table', compact('domain', 'object', 'attributes'));
    }
}

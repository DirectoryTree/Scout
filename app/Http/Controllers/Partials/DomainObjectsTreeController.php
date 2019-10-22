<?php

namespace App\Http\Controllers\Partials;

use App\Scout;
use App\LdapDomain;

class DomainObjectsTreeController
{
    /**
     * Get the children in a tree view for the given object.
     *
     * @param LdapDomain $domain
     * @param string     $objectId
     *
     * @return \App\Http\ScoutResponse
     */
    public function show(LdapDomain $domain, $objectId)
    {
        /** @var \App\LdapObject $parent */
        $parent = $domain->objects()->findOrFail($objectId);

        $objects = $parent->children()->withCount('children')->get();

        return Scout::response()->render(
            view('domains.objects.partials.tree', compact('domain', 'objects', 'parent'))
        )->into("leaves_{$parent->id}");
    }
}

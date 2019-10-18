<?php

namespace App\Http\Controllers;

use Exception;
use App\LdapDomain;
use App\LdapObject;
use App\Jobs\SyncSingleObject;
use Illuminate\Support\Facades\Bus;

class DomainObjectSyncController
{
    /**
     * Synchronizes the object.
     *
     * @param LdapDomain $domain
     * @param int        $objectId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(LdapDomain $domain, $objectId)
    {
        /** @var LdapObject $object */
        $object = $domain->objects()
            ->with('parent')
            ->findOrFail($objectId);

        try {
            Bus::dispatch(new SyncSingleObject($domain, $object));
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()]);
        }

        return response()->turbolinks(route('domains.objects.attributes.index', [$domain, $object]), $replace = true);
    }
}

<?php

namespace App\Http\Controllers;

use Exception;
use App\Scout;
use App\LdapDomain;
use App\LdapObject;
use App\Actions\SyncObjectAction;

class DomainObjectSyncController
{
    /**
     * Synchronizes the object.
     *
     * @param LdapDomain $domain
     * @param int        $objectId
     *
     * @return \App\Http\ScoutResponse
     */
    public function update(LdapDomain $domain, $objectId)
    {
        /** @var LdapObject $object */
        $object = $domain->objects()
            ->with('parent')
            ->findOrFail($objectId);

        try {
            (new SyncObjectAction($domain, $object))->execute();
        } catch (Exception $ex) {
            return Scout::response()
                ->type('error')
                ->notifyWithMessage($ex->getMessage());
        }

        return Scout::response()
            ->notifyWithMessage('Synchronized object.')
            ->visit(route('domains.objects.attributes.index', [$domain, $object]));
    }
}

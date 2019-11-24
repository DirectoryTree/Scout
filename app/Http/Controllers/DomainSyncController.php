<?php

namespace App\Http\Controllers;

use App\Scout;
use App\LdapDomain;
use App\Jobs\ScanDomain;

class DomainSyncController
{
    /**
     * Queues the synchronization of the domain.
     *
     * @param LdapDomain $domain
     *
     * @return \App\Http\ScoutResponse
     */
    public function store(LdapDomain $domain)
    {
        ScanDomain::dispatch($domain);

        return Scout::response()
            ->notifyWithMessage('Queued synchronization.')
            ->visit(route('domains.show', $domain));
    }
}

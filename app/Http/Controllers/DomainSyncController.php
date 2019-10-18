<?php

namespace App\Http\Controllers;

use App\LdapDomain;
use App\Jobs\QueueSync;
use Illuminate\Support\Facades\Bus;

class DomainSyncController
{
    /**
     * Queues the synchronization of the domain.
     *
     * @param LdapDomain $domain
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LdapDomain $domain)
    {
        Bus::dispatch(new QueueSync($domain));

        return response()->turbolinks(route('domains.show', $domain));
    }
}

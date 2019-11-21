<?php

namespace App\Jobs;

use App\LdapScan;
use App\LdapDomain;
use Illuminate\Foundation\Bus\Dispatchable;

class QueueSync
{
    use Dispatchable;

    /**
     * The LDAP domain being synchronized.
     *
     * @var LdapDomain
     */
    protected $domain;

    /**
     * Create a new job instance.
     *
     * @param LdapDomain $domain
     */
    public function __construct(LdapDomain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $scan = tap(new LdapScan(), function (LdapScan $scan) {
            $scan->domain()->associate($this->domain)->save();
        });

        SyncDomain::dispatch($this->domain, $scan);
    }
}

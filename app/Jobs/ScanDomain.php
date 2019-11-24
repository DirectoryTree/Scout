<?php

namespace App\Jobs;

use App\LdapScan;
use App\LdapDomain;
use Illuminate\Foundation\Bus\Dispatchable;

class ScanDomain
{
    use Dispatchable;

    /**
     * The LDAP domain.
     *
     * @var LdapDomain
     */
    protected $domain;

    /**
     * Create a new job instance.
     *
     * @param LdapDomain $domain
     *
     * @return void
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
        /** @var LdapScan $scan */
        $scan = $this->domain->scans()->create();

        ImportDomain::withChain([
            new ProcessImported($scan),
            new DeleteMissingObjects($scan),
            new PurgeImported($scan)
        ])->dispatch($scan);
    }
}

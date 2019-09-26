<?php

namespace App\Jobs;

use Exception;
use App\LdapDomain;
use App\LdapObject;
use App\Ldap\DomainConnector;
use LdapRecord\Models\Entry;
use Illuminate\Support\Facades\Bus;

class SyncSingleObject
{

    /**
     * The domain the entry is being imported from.
     *
     * @var LdapDomain
     */
    protected $domain;

    /**
     * The LDAP object being synced.
     *
     * @var LdapObject
     */
    protected $object;

    /**
     * Constructor.
     *
     * @param LdapDomain $domain
     * @param LdapObject $object
     */
    public function __construct(LdapDomain $domain, LdapObject $object)
    {
        $this->domain = $domain;
        $this->object = $object;
    }

    /**
     * Execute the job.
     *
     * @return void
     *
     * @throws \LdapRecord\Auth\BindException
     * @throws \LdapRecord\ConnectionException
     * @throws \LdapRecord\Models\ModelNotFoundException
     */
    public function handle()
    {
        $connector = new DomainConnector($this->domain);

        $connector->connect();

        $entry = Entry::on($connector->getConnectionName())->findOrFail($this->object->dn);

        Bus::dispatch(new SyncObject($this->domain, $entry, $this->object->parent));
    }
}

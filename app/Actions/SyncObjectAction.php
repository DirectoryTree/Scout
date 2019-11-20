<?php

namespace App\Actions;

use App\LdapDomain;
use App\LdapObject;
use App\Ldap\ObjectImporter;
use App\Ldap\Connectors\DomainConnector;

class SyncObjectAction extends Action
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
    public function execute()
    {
        (new DomainConnector($this->domain))->connect();

        $entry = $this->domain->getLdapModel()->findOrFail($this->object->dn);

        (new ObjectImporter($this->domain, $entry))->run($this->object->parent);
    }
}

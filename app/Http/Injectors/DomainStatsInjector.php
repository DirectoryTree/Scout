<?php

namespace App\Http\Injectors;

use Illuminate\Http\Request;

class DomainStatsInjector
{
    /**
     * The LDAP domain.
     *
     * @var \App\LdapDomain
     */
    protected $domain;

    /**
     * Constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->domain = $request->domain;
    }

    /**
     * Get the total number of objects in the domain.
     *
     * @return int
     */
    public function getObjectCount()
    {
        return $this->domain->objects()->count();
    }

    /**
     * Get the total number of changes in the domain.
     *
     * @return int
     */
    public function getChangeCount()
    {
        return $this->domain->changes()->count();
    }
}

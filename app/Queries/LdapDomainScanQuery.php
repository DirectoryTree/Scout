<?php


namespace App\Queries;

use App\LdapDomain;

class LdapDomainScanQuery
{
    /**
     * @var LdapDomain
     */
    protected $domain;

    /**
     * Constructor.
     *
     * @param LdapDomain $domain
     */
    public function __construct(LdapDomain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Paginate the domain scans.
     *
     * @param int $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 10)
    {
        return $this->domain->scans()->latest()->paginate($perPage);
    }
}

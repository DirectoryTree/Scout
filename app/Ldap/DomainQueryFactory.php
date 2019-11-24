<?php

namespace App\Ldap;

use App\LdapDomain;
use LdapRecord\Models\Model;
use LdapRecord\Query\Model\Builder;

class DomainQueryFactory
{
    /**
     * The lDAP domain.
     *
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
     * Create a new query from the given model.
     *
     * @param Model $model
     *
     * @return Builder
     */
    public function make(Model $model)
    {
        return tap($model->newQuery(), function (Builder $query) {
            if ($filter = $this->domain->filter) {
                $query->rawFilter($filter);
            }
        });
    }
}

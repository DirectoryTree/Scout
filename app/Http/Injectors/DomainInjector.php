<?php

namespace App\Http\Injectors;

use App\LdapDomain;

class DomainInjector
{
    /**
     * Get all configured LDAP domains.
     *
     * @return mixed
     */
    public function get()
    {
        return LdapDomain::select(['name', 'slug', 'status'])->get();
    }
}

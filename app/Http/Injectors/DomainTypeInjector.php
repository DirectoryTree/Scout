<?php

namespace App\Http\Injectors;

use App\LdapDomain;

class DomainTypeInjector
{
    /**
     * Get the available domain types.
     *
     * @return array
     */
    public function get()
    {
        return [
            LdapDomain::TYPE_ACTIVE_DIRECTORY => __('ActiveDirectory'),
            LdapDomain::TYPE_ACTIVE_DIRECTORY_LDS => __('ActiveDirectory (LDS)'),
            LdapDomain::TYPE_OPEN_LDAP => __('OpenLDAP'),
            LdapDomain::TYPE_UNKNOWN => __('Other'),
        ];
    }
}

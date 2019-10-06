<?php

namespace App\Installer;

class LdapRequirement extends Requirement
{
    /**
     * The name of the requirement.
     *
     * @return string
     */
    public function name()
    {
        return __('LDAP Extension');
    }

    /**
     * The description of the requirement.
     *
     * @return string
     */
    public function description()
    {
        return __('The PHP LDAP extension must be enabled.');
    }

    /**
     * Whether the requirement passes.
     *
     * @return bool
     */
    public function passes()
    {
        return extension_loaded('ldap');
    }
}

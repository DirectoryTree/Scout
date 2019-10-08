<?php

namespace App\Ldap\Conditions;

class NotEquals extends Equals
{
    /**
     * {@inheritDoc}
     */
    public function passes()
    {
        return !parent::passes();
    }
}

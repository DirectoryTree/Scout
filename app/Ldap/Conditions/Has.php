<?php

namespace App\Ldap\Conditions;

class Has extends Condition
{
    /**
     * {@inheritDoc}
     */
    function passes()
    {
        return !empty($this->current);
    }
}

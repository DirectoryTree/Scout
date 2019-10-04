<?php

namespace App\Ldap\Conditions;

class Contains extends Condition
{
    /**
     * {@inheritDoc}
     */
    public function passes()
    {
        return in_array($this->value, $this->current);
    }
}

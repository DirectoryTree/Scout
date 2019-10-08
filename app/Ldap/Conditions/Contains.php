<?php

namespace App\Ldap\Conditions;

class Contains extends Condition
{
    /**
     * {@inheritDoc}
     */
    public function passes()
    {
        foreach ($this->current as $value) {
            if (in_array($value, $this->values)) {
                return true;
            }
        }

        return false;
    }
}

<?php

namespace App\Ldap\Conditions;

class Changed extends Condition
{
    /**
     * Determine if the condition passes.
     *
     * @return bool
     */
    function passes()
    {
        return array_values($this->current) != array_values($this->values);
    }
}

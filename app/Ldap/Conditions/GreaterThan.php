<?php

namespace App\Ldap\Conditions;

use Illuminate\Support\Arr;

class GreaterThan extends Condition
{
    /**
     * Determine if the condition passes.
     *
     * @return bool
     */
    function passes()
    {
        if (($current = Arr::first($this->current)) && is_numeric($current)) {
            return $current > Arr::first($this->values);
        }

        return false;
    }
}

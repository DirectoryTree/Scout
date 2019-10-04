<?php

namespace App\Ldap\Conditions;

use Illuminate\Support\Arr;

class Equals extends Condition
{
    /**
     * {@inheritDoc}
     */
    public function passes()
    {
        // Our current value will always be contained inside of an array due
        // to LDAPs multi-valued nature. We must also wrap our conditions
        // value in an array for comparison as it may be a string.
        return array_map('strtolower', $this->current) ==
            array_map('strtolower', Arr::wrap($this->value));
    }
}

<?php

namespace App\Ldap\Conditions;

use Carbon\Carbon;
use Illuminate\Support\Arr;

class IsPast extends Condition
{
    /**
     * {@inheritDoc}
     */
    function passes()
    {
        if (($current = Arr::first($this->current)) && $current instanceof Carbon) {
            return $current->isPast();
        }
    }
}

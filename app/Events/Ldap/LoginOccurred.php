<?php

namespace App\Events\Ldap;

use Illuminate\Support\Arr;

class LoginOccurred extends Event
{
    /**
     * {@inheritDoc}
     */
    public function getSubject() : string
    {
        $name = Arr::get($this->object->attributes, 'cn.0');

        $subject = "User $name has logged in.";

        logger($subject);

        return $subject;
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription() : string
    {
        return "";
    }
}

<?php

namespace App\Events\Ldap;

class LoginOccurred extends Event
{
    /**
     * {@inheritDoc}
     */
    public function getSubject() : string
    {
        return "User {$this->getObjectName()} has logged in at {$this->getFirstValue()}.";
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription() : string
    {
        // TODO: Determine model type and return human timestamp.
        return "";
    }
}

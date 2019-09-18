<?php

namespace App\Events\Ldap;

class UserMembershipsChanged extends Event
{
    /**
     * {@inheritDoc}
     */
    public function getSubject(): string
    {
        return "User '{$this->getObjectName()}' ({$this->getObjectDn()}) has had their group memberships changed.";
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription(): string
    {
        return "";
    }
}

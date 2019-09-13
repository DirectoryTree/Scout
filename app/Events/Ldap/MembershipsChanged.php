<?php

namespace App\Events\Ldap;

class MembershipsChanged extends Event
{
    /**
     * {@inheritDoc}
     */
    public function getSubject() : string
    {
        return "Group '{$this->getObjectName()}' ({$this->getObjectDn()}) has had their memberships changed.";
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription() : string
    {
        $members = implode($this->getValue(), ', ');

        return "Group members are now: $members.";
    }
}

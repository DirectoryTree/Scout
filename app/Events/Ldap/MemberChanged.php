<?php

namespace App\Events\Ldap;

class MemberChanged extends Event
{
    public function getSubject() : string
    {
        return "";
    }

    public function getDescription() : string
    {
        return "";
    }
}

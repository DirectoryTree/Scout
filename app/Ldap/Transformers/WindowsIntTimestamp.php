<?php

namespace App\Ldap\Transformers;

class WindowsIntTimestamp extends Timestamp
{
    /**
     * The LDAP timestamp type.
     *
     * @var string
     */
    protected $type = 'windows-int';
}

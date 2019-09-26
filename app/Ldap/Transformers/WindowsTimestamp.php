<?php

namespace App\Ldap\Transformers;

class WindowsTimestamp extends Timestamp
{
    /**
     * The LDAP timestamp type.
     *
     * @var string
     */
    protected $type = 'windows';
}

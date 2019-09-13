<?php

namespace App\Events\Ldap;

use App\LdapObject;

abstract class Event
{
    /**
     * The LDAP object that was changed.
     *
     * @var LdapObject
     */
    public $object;

    /**
     * The new value of the LDAP change.
     *
     * @var array
     */
    public $value;

    /**
     * Constructor.
     *
     * @param LdapObject $object
     * @param array      $value
     */
    public function __construct(LdapObject $object, array $value = [])
    {
        $this->object = $object;
        $this->value = $value;
    }

    /**
     * Returns the subject of the event.
     *
     * @return string
     */
    abstract public function getSubject() : string;

    /**
     * Returns the full description of the event.
     *
     * @return string
     */
    abstract public function getDescription() : string;
}

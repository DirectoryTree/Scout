<?php

namespace App\Events\Ldap;

use App\LdapObject;
use App\LdapChange;
use Illuminate\Support\Arr;

abstract class Event
{
    /**
     * The LDAP change record.
     *
     * @var LdapChange
     */
    public $change;

    /**
     * The LDAP object that was changed.
     *
     * @var LdapObject
     */
    public $object;

    /**
     * The new value of the LDAP change.
     *
     * @var string
     */
    public $attribute;

    /**
     * Constructor.
     *
     * @param LdapChange $change
     * @param LdapObject $object
     * @param array      $attribute
     */
    public function __construct(LdapChange $change, LdapObject $object, $attribute)
    {
        $this->change = $change;
        $this->object = $object;
        $this->attribute = $attribute;
    }

    /**
     * Get the common name from the LDAP object.
     *
     * @return string
     */
    public function getObjectName()
    {
        return Arr::get($this->object->attributes, 'cn.0');
    }

    /**
     * Returns the objects (current) distinguished name.
     *
     * @return string
     */
    public function getObjectDn()
    {
        return $this->object->dn;
    }

    /**
     * Get the value of the changed attribute.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->change->attributes[$this->attribute];
    }

    /**
     * Get the first value of the changed attribute.
     *
     * @return string
     */
    public function getFirstValue()
    {
        return Arr::first($this->getValue());
    }

    /**
     * Get the subject of the event.
     *
     * @return string
     */
    abstract public function getSubject() : string;

    /**
     * Get the full description of the event.
     *
     * @return string
     */
    abstract public function getDescription() : string;
}

<?php

namespace App\Ldap;

use LdapRecord\Models\Entry;

class TypeGuesser
{
    /**
     * The LDAP entry.
     *
     * @var Entry
     */
    protected $entry;

    /**
     * The LDAP entry's object classes.
     *
     * @var array
     */
    protected $classes = [];

    /**
     * The objectclass type map.
     *
     * @var array
     */
    protected $map = [
        'user'                  => 'user',
        'inetorgperson'         => 'user',
        'group'                 => 'group',
        'domain'                => 'domain',
        'locality'              => 'container',
        'container'             => 'container',
        'lostandfound'          => 'container',
        'organizationalunit'    => 'container',
    ];

    /**
     * Constructor.
     *
     * @param Entry $entry
     */
    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
        $this->classes = $entry->objectclass ?? [];
    }

    /**
     * Determine the LDAP objects type.
     *
     * @return mixed
     */
    public function get()
    {
        foreach ($this->classes as $class) {
            if (array_key_exists($class, $this->map)) {
                return $this->map[$class];
            }
        }
    }
}

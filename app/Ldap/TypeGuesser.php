<?php

namespace App\Ldap;

class TypeGuesser
{
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
        'groupofnames'          => 'group',
        'groupofentries'        => 'group',
        'groupofuniquenames'    => 'group',
        'domain'                => 'domain',
        'locality'              => 'container',
        'container'             => 'container',
        'lostandfound'          => 'container',
        'organizationalunit'    => 'container',
        'msds-quotacontainer'   => 'container',
    ];

    /**
     * Constructor.
     *
     * @param array $classes
     */
    public function __construct(array $classes = [])
    {
        $this->classes = array_map('strtolower', $classes);
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

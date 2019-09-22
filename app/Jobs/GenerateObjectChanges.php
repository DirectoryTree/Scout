<?php

namespace App\Jobs;

use App\LdapChange;
use App\LdapObject;

class GenerateObjectChanges
{
    /**
     * The LDAP object that has been modified.
     *
     * @var LdapObject
     */
    protected $object;

    /**
     * The LDAP objects modified attributes and their new values.
     *
     * @var array
     */
    protected $modified = [];

    /**
     * The LDAP objects old attributes.
     *
     * @var array
     */
    protected $old = [];

    /**
     * Create a new job instance.
     *
     * @param LdapObject $object
     * @param array      $modified
     * @param array      $old
     *
     * @return void
     */
    public function __construct(LdapObject $object, array $modified = [], array $old = [])
    {
        $this->object = $object;
        $this->modified = $modified;
        $this->old = $old;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->modified as $attribute => $values) {
            $change = new LdapChange();

            $change->object()->associate($this->object);

            $before = array_key_exists($attribute, $this->old) ? $this->old[$attribute] : [];

            $change->fill([
                'attribute' => $attribute,
                'before' => $before,
                'after' => unserialize($values),
            ])->save();
        }
    }
}

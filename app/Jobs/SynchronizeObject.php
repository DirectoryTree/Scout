<?php

namespace App\Jobs;

use App\LdapChange;
use App\LdapDomain;
use App\LdapObject;
use App\Ldap\TypeGuesser;
use LdapRecord\Utilities;
use Illuminate\Support\Arr;
use LdapRecord\Models\ActiveDirectory\Entry;

class SynchronizeObject
{
    /**
     * The global attribute blacklist.
     *
     * @var array
     */
    protected $blacklist = [];

    /**
     * The domain the entry is being imported from.
     *
     * @var LdapDomain
     */
    protected $domain;

    /**
     * The LDAP object being imported.
     *
     * @var Entry
     */
    protected $entry;

    /**
     * The parent LDAP object.
     *
     * @var LdapObject|null
     */
    protected $parent;

    /**
     * Create a new job instance.
     *
     * @param LdapDomain      $domain
     * @param Entry           $entry
     * @param LdapObject|null $parent
     */
    public function __construct(LdapDomain $domain, Entry $entry, LdapObject $parent = null)
    {
        $this->domain = $domain;
        $this->entry = $entry;
        $this->parent = $parent;
    }

    /**
     * Execute the job.
     *
     * @return LdapObject
     */
    public function handle()
    {
        // Retrieve the LDAP entry's attributes and sort them by their key.
        $attributes = $this->getFilteredAttributes();
        ksort($attributes);

        /** @var LdapObject $object */
        $object = LdapObject::firstOrNew(['guid' => $this->getObjectGuid()]);

        // Determine any differences from our last sync.
        $modifications = array_diff(
            array_map('serialize', $attributes),
            array_map('serialize', $object->attributes ?? [])
        );

        $object->domain()->associate($this->domain);

        if ($this->parent) {
            $object->parent()->associate($this->parent);
        }

        $object->name = $this->getObjectName();
        $object->dn = $this->getObjectDn();
        $object->type = $this->getObjectType();
        $object->attributes = $attributes;

        $object->save();

        if (count($modifications) > 0) {
            $change = new LdapChange();

            $change->object()->associate($object);

            $change->fill([
                'before' => $attributes,
                'after' => $object->attributes,
                'attributes' => array_map('unserialize', $modifications),
            ])->save();
        }

        return $object;
    }

    /**
     * Returns the objects GUID.
     *
     * @return string|null
     */
    protected function getObjectGuid()
    {
        return $this->entry->getConvertedGuid();
    }

    /**
     * Returns the objects distinguished named.
     *
     * @return string|null
     */
    protected function getObjectDn()
    {
        return $this->entry->getDn();
    }

    /**
     * Get the LDAP objects name.
     *
     * @return mixed
     */
    protected function getObjectName()
    {
        $parts = Utilities::explodeDn($this->entry->getDn(), true);

        return Arr::first(Arr::except($parts, 'count'));
    }

    /**
     * Get the LDAP objects type.
     *
     * @var string
     */
    protected function getObjectType()
    {
        return (new TypeGuesser($this->entry))->get();
    }

    /**
     * Returns the attributes except the blacklisted.
     *
     * @return array
     */
    protected function getFilteredAttributes()
    {
        if (count($this->blacklist) === 0) {
            return $this->entry->jsonSerialize();
        }

        return array_filter($this->entry->jsonSerialize(), function ($key) {
            return ! in_array($key, $this->blacklist);
        }, ARRAY_FILTER_USE_KEY);
    }
}

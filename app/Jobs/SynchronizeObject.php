<?php

namespace App\Jobs;

use App\LdapDomain;
use App\LdapObject;
use App\Ldap\TypeGuesser;
use LdapRecord\Utilities;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Bus;
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
        $newAttributes = $this->getFilteredAttributes();
        ksort($newAttributes);

        /** @var LdapObject $object */
        $object = LdapObject::firstOrNew(['guid' => $this->getObjectGuid()]);

        $oldAttributes = $object->attributes ?? [];

        // Determine any differences from our last sync.
        $modifications = array_diff(
            array_map('serialize', $newAttributes),
            array_map('serialize', $oldAttributes)
        );

        $object->domain()->associate($this->domain);

        if ($this->parent) {
            $object->parent()->associate($this->parent);
        } else {
            $object->parent()->dissociate();
        }

        $object->name = $this->getObjectName();
        $object->dn = $this->getObjectDn();
        $object->type = $this->getObjectType();
        $object->attributes = $newAttributes;

        $object->save();

        if (count($modifications) > 0) {
            Bus::dispatch(new GenerateObjectChanges($object, $modifications, $oldAttributes));
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

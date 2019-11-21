<?php

namespace App\Ldap;

use App\LdapDomain;
use App\LdapObject;
use Illuminate\Pipeline\Pipeline;
use LdapRecord\Models\Model as LdapModel;
use Illuminate\Database\Eloquent\Model as DatabaseModel;

class ObjectImporter
{
    /**
     * The LDAP domain that the object belongs to.
     *
     * @var LdapDomain
     */
    protected $domain;

    /**
     * The LDAP object to import.
     *
     * @var LdapModel
     */
    protected $object;

    /**
     * The pipes to run through the pipeline.
     *
     * @var array
     */
    protected $pipes = [
        Pipes\RestoreModelWhenTrashed::class,
        Pipes\AssociateDomain::class,
        Pipes\AssociateParent::class,
        Pipes\DetectChanges::class,
        Pipes\HydrateProperties::class,
    ];

    /**
     * Constructor.
     *
     * @param LdapDomain $domain
     * @param LdapModel  $object
     */
    public function __construct(LdapDomain $domain, LdapModel $object)
    {
        $this->domain = $domain;
        $this->object = $object;
    }

    /**
     * Import / synchronize the object into the database.
     *
     * @param DatabaseModel|null $parent
     *
     * @return LdapObject
     */
    public function run(DatabaseModel $parent = null)
    {
        $guid = $this->object->getConvertedGuid();

        $model = LdapObject::withTrashed()->firstOrNew(['guid' => $guid]);

        $pipes = collect($this->pipes)->transform(function ($pipe) use ($parent) {
            return new $pipe($this->domain, $this->object, $parent);
        })->toArray();

        return app(Pipeline::class)
            ->send($model)
            ->through($pipes)
            ->then(function (DatabaseModel $model) {
                $model->save();

                return $model;
            });
    }
}

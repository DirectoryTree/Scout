<?php

namespace App\Ldap\Pipes;

use Closure;
use App\Ldap\TypeGuesser;
use LdapRecord\Utilities;
use Illuminate\Support\Arr;
use App\LdapObject as DatabaseModel;

class HydrateProperties extends Pipe
{
    /**
     * Perform operations on the LDAP object model being synchronized.
     *
     * @param DatabaseModel $model
     * @param Closure       $next
     *
     * @return void
     */
    public function handle(DatabaseModel $model, Closure $next)
    {
        $newAttributes = $this->object->jsonSerialize();
        ksort($newAttributes);

        $model->dn = $this->object->getDn();
        $model->name = $this->getObjectName();
        $model->type = $this->getObjectType();
        $model->values = $newAttributes;

        return $next($model);
    }

    /**
     * Get the LDAP objects name.
     *
     * @return mixed
     */
    protected function getObjectName()
    {
        $parts = Utilities::explodeDn($this->object->getRdn(), true);

        return Arr::first($parts);
    }

    /**
     * Get the LDAP objects type.
     *
     * @var string
     */
    protected function getObjectType()
    {
        return (new TypeGuesser($this->object->objectclass ?? []))->get();
    }
}

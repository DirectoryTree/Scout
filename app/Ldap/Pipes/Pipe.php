<?php

namespace App\Ldap\Pipes;

use Closure;
use App\LdapDomain;
use App\LdapObject as DatabaseModel;
use LdapRecord\Models\Model as LdapModel;

abstract class Pipe
{
    /**
     * The LDAP domain.
     *
     * @var LdapDomain
     */
    protected $domain;

    /**
     * The LDAP model.
     *
     * @var LdapModel
     */
    protected $object;

    /**
     * The parent database model of the object.
     *
     * @var DatabaseModel|null
     */
    protected $parent;

    /**
     * Constructor.
     *
     * @param LdapDomain         $domain
     * @param LdapModel          $object
     * @param DatabaseModel|null $parent
     */
    public function __construct(LdapDomain $domain, LdapModel $object, DatabaseModel $parent = null)
    {
        $this->domain = $domain;
        $this->object = $object;
        $this->parent = $parent;
    }

    /**
     * Perform operations on the LDAP object model being synchronized.
     *
     * @param DatabaseModel $model
     * @param Closure       $next
     *
     * @return void
     */
    abstract public function handle(DatabaseModel $model, Closure $next);
}

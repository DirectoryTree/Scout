<?php

namespace App\Ldap\Pipes;

use Closure;
use App\LdapObject as DatabaseModel;

class AssociateParent extends Pipe
{
    /**
     * Associate the parent model if it exists, or detach it if not.
     *
     * @param DatabaseModel $model
     * @param Closure       $next
     *
     * @return void
     */
    public function handle(DatabaseModel $model, Closure $next)
    {
        if ($this->parent) {
            $model->parent()->associate($this->parent);
        } else {
            $model->parent()->dissociate();
        }

        return $next($model);
    }
}

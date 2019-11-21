<?php

namespace App\Ldap\Pipes;

use Closure;
use App\LdapObject;

class RestoreModelWhenTrashed extends Pipe
{
    /**
     * Restore the model if it's trashed.
     *
     * @param LdapObject $model
     * @param Closure    $next
     *
     * @return void
     */
    public function handle(LdapObject $model, Closure $next)
    {
        if ($model->trashed()) {
            $model->restore();
        }

        return $next($model);
    }
}

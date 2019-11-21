<?php

namespace App\Ldap\Pipes;

use Closure;
use Carbon\Carbon;
use App\Jobs\GenerateObjectChanges;
use App\LdapObject as DatabaseModel;
use LdapRecord\Models\Types\ActiveDirectory;

class DetectChanges extends Pipe
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

        $oldAttributes = $model->values ?? [];

        // Determine any differences from our last sync.
        $modifications = array_diff(
            array_map('serialize', $newAttributes),
            array_map('serialize', $oldAttributes)
        );

        // We don't want to create changes for newly imported objects.
        if ($model->exists && count($modifications) > 0) {
            $when = $this->getObjectUpdatedDate();

            GenerateObjectChanges::dispatch($model, $when, $modifications, $oldAttributes);
        }

        return $next($model);
    }

    /**
     * Get the LDAP objects modified date.
     *
     * @return Carbon
     */
    protected function getObjectUpdatedDate()
    {
        $attribute = 'modifytimestamp';

        if ($this->object instanceof ActiveDirectory) {
            $attribute = 'whenchanged';
        }

        $timestamp = $this->object->{$attribute};

        return $timestamp instanceof Carbon ?
            $timestamp->setTimezone(config('app.timezone')) :
            now();
    }
}

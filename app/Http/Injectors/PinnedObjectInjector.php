<?php

namespace App\Http\Injectors;

use App\LdapObject;

class PinnedObjectInjector
{
    /**
     * Get all pinned objects.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get()
    {
        return LdapObject::with('domain')
            ->where('pinned', '=', true)
            ->get();
    }
}

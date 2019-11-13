<?php

namespace App\Http\Injectors;

use Illuminate\Support\Facades\Auth;

class PinnedObjectInjector
{
    /**
     * Get all pinned objects.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get()
    {
        return Auth::user()->pins()->get();
    }
}

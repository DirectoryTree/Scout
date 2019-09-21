<?php

namespace App\Http\View\Composers;

use App\LdapChange;
use Illuminate\Contracts\View\View;

class DomainLayoutComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $domain = request()->domain;

        $view->with(['counts' => [
            'objects' => $domain->objects()->count(),
            'changes' => LdapChange::whereHas('object', function ($query) use ($domain) {
                return $query->whereIn('object_id', $domain->objects()->get('id'));
            })->count()
        ]]);
    }
}

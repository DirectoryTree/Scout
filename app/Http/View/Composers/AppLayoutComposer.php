<?php

namespace App\Http\View\Composers;

use App\LdapDomain;
use Illuminate\Contracts\View\View;

class AppLayoutComposer
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
        $view->with(['counts' => [
            'domains' => LdapDomain::count(),
        ]]);
    }
}

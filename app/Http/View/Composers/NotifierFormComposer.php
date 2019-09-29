<?php

namespace App\Http\View\Composers;

use App\LdapNotifier;
use Illuminate\Contracts\View\View;

class NotifierFormComposer
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
        $view->with([
            'types' => LdapNotifier::types(),
            'operators' => LdapNotifier::operators(),
        ]);
    }
}

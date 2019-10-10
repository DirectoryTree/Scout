<?php

namespace App\Http\View\Composers;

use App\LdapDomain;
use App\Notifications;
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
        $notifications = (new Notifications(request()->user()));

        $view->with([
            'counts' => ['domains' => LdapDomain::count()],
            'notifications' => $notifications->get(),
        ]);
    }
}

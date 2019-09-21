<?php

namespace App\Http\View\Composers;

use App\LdapDomain;
use Illuminate\Contracts\View\View;

class DomainFormComposer
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
        $view->with(['types' => [
            LdapDomain::TYPE_ACTIVE_DIRECTORY => __('Active Directory'),
            LdapDomain::TYPE_OPEN_LDAP => __('OpenLDAP'),
            LdapDomain::TYPE_UNKNOWN => __('Other'),
        ]]);
    }
}

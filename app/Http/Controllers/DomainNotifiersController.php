<?php

namespace App\Http\Controllers;

use App\LdapDomain;

class DomainNotifiersController
{
    /**
     * Displays all the setup LDAP notifications for the domain.
     *
     * @param LdapDomain $domain
     *
     * @return \Illuminate\View\View
     */
    public function index(LdapDomain $domain)
    {
        $notifiers = $domain->notifiers()->latest()->paginate(25);

        return view('domains.notifiers.index', compact('domain', 'notifiers'));
    }
}

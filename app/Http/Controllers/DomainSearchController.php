<?php

namespace App\Http\Controllers;

use App\LdapDomain;

class DomainSearchController
{
    /**
     * Displays the search form.
     *
     * @param LdapDomain $domain
     *
     * @return \Illuminate\View\View
     */
    public function index(LdapDomain $domain)
    {
        return view('domains.search.index', compact('domain'));
    }
}

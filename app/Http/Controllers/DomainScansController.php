<?php

namespace App\Http\Controllers;

use App\LdapDomain;

class DomainScansController extends Controller
{
    /**
     * Displays all the LDAP domains scans.
     *
     * @param LdapDomain $domain
     *
     * @return \Illuminate\View\View
     */
    public function index(LdapDomain $domain)
    {
        $scans = $domain->scans()->latest()->paginate(10);

        return view('domains.scans.index', compact('domain', 'scans'));
    }
}

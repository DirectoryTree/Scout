<?php

namespace App\Http\Controllers;

use App\LdapDomain;
use App\Queries\LdapDomainScanQuery;

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
        $scans = (new LdapDomainScanQuery($domain))->paginate();

        return view('domains.scans.index', compact('domain', 'scans'));
    }
}

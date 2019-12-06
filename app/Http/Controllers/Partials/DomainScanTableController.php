<?php

namespace App\Http\Controllers\Partials;

use App\LdapDomain;
use App\Http\Controllers\Controller;
use App\Queries\LdapDomainScanQuery;

class DomainScanTableController extends Controller
{
    /**
     * Display a table of the domain scans.
     *
     * @param LdapDomain $domain
     *
     * @return \Illuminate\View\View
     */
    public function show(LdapDomain $domain)
    {
        $scans = (new LdapDomainScanQuery($domain))->paginate();

        return view('domains.scans.partials.table', compact('domain', 'scans'));
    }
}

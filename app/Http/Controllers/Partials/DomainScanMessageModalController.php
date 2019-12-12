<?php

namespace App\Http\Controllers\Partials;

use App\LdapDomain;
use App\Http\Controllers\Controller;

class DomainScanMessageModalController extends Controller
{
    /**
     * Returns the message modal for the domain scan.
     *
     * @param LdapDomain $domain
     * @param string     $scanId
     *
     * @return \Illuminate\View\View
     */
    public function show(LdapDomain $domain, $scanId)
    {
        $scan = $domain->scans()->select(['id', 'message'])->findOrFail($scanId);

        return view('domains.scans.partials.message-modal', compact('domain', 'scan'));
    }
}

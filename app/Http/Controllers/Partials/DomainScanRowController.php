<?php

namespace App\Http\Controllers\Partials;

use App\LdapDomain;

class DomainScanRowController
{
    /**
     * Displays a domain scan table row.
     *
     * @param LdapDomain $domain
     * @param int        $scanId
     *
     * @return \Illuminate\View\View
     */
    public function show(LdapDomain $domain, $scanId)
    {
        $scan = $domain->scans()->findOrFail($scanId);

        return view('domains.scans.partials.row', compact('domain', 'scan'));
    }
}

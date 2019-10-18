<?php

namespace App\Http\Controllers;

use App\LdapChange;
use App\LdapDomain;
use Illuminate\Support\Facades\DB;

class DomainChangesController extends Controller
{
    /**
     * Displays all of the domains attribute cahnges.
     *
     * @param LdapDomain $domain
     *
     * @return \Illuminate\View\View
     */
    public function index(LdapDomain $domain)
    {
        $changes = LdapChange::whereHas('object', function ($query) use ($domain) {
            return $query->where('domain_id', '=', $domain->id);
        })->groupBy('attribute')
            ->select(DB::raw('count(*) as count, max(ldap_updated_at) as ldap_updated_at, attribute'))
            ->orderBy(DB::raw('max(ldap_updated_at)'), 'desc')
            ->paginate(25);

        return view('domains.changes.index', compact('domain', 'changes'));
    }

    /**
     * Displays the global attributes changes for the given domain.
     *
     * @param LdapDomain $domain
     * @param string     $attribute
     *
     * @return \Illuminate\View\View
     */
    public function show(LdapDomain $domain, $attribute)
    {
        $changes = LdapChange::whereHas('object', function ($query) use ($domain) {
            return $query->where('domain_id', '=', $domain->id);
        })->with('object')
            ->where('attribute', '=', $attribute)
            ->orderBy('ldap_updated_at', 'desc')
            ->paginate(25);

        return view('domains.changes.show', compact('domain', 'changes', 'attribute'));
    }
}

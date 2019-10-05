<?php

namespace App\Http\Controllers;

use App\LdapDomain;
use Illuminate\Support\Facades\DB;

class DomainObjectChangesController extends Controller
{
    /**
     * Displays the LDAP objects changes.
     *
     * @param LdapDomain $domain
     * @param int        $objectId
     *
     * @return \Illuminate\View\View
     */
    public function index(LdapDomain $domain, $objectId)
    {
        $object = $domain->objects()->withTrashed()->findOrFail($objectId);

        $changes = $object->changes()
            ->select(DB::raw('COUNT(*) as count, attribute, max(ldap_updated_at) as ldap_updated_at'))
            ->groupBy('attribute')
            ->orderBy('ldap_updated_at', 'desc')
            ->paginate(20);

        return view('domains.objects.changes.index', compact(
            'domain',
            'object',
            'changes'
        ));
    }

    /**
     * Displays the objects attribute changes.
     *
     * @param LdapDomain $domain
     * @param int        $objectId
     * @param string     $attribute
     *
     * @return \Illuminate\View\View
     */
    public function show(LdapDomain $domain, $objectId, $attribute)
    {
        $object = $domain->objects()->withTrashed()->findOrFail($objectId);

        $changes = $object->changes()
            ->where('attribute', '=', $attribute)
            ->latest()
            ->paginate(20);

        return view('domains.objects.changes.show', compact(
            'domain',
            'object',
            'attribute',
            'changes'
        ));
    }
}

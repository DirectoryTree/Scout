<?php

namespace App\Http\Controllers;

use Exception;
use App\LdapDomain;
use App\LdapObject;
use App\Jobs\SyncSingleObject;
use Illuminate\Support\Facades\Bus;

class DomainObjectsController extends Controller
{
    /**
     * Displays all of the domains objects.
     *
     * @param LdapDomain $domain
     *
     * @return \Illuminate\View\View
     */
    public function index(LdapDomain $domain)
    {
        $objects = $domain->objects()
            ->whereNull('parent_id')
            ->orderBy('name')
            ->paginate(25);

        return view('domains.objects.index', compact('domain', 'objects'));
    }

    /**
     * Displays the LDAP objects descendants.
     *
     * @param LdapDomain $domain
     * @param int        $objectId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(LdapDomain $domain, $objectId)
    {
        /** @var LdapObject $object */
        $object = $domain->objects()
            ->with('parent')
            ->withTrashed()
            ->find($objectId);

        $objects = $object->descendants()
            ->orderBy('name')
            ->paginate(25);

        return view('domains.objects.show', compact('domain', 'object', 'objects'));
    }

    /**
     * Synchronizes the object.
     *
     * @param LdapDomain $domain
     * @param int        $objectId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sync(LdapDomain $domain, $objectId)
    {
        /** @var LdapObject $object */
        $object = $domain->objects()
            ->with('parent')
            ->findOrFail($objectId);

        try {
            Bus::dispatch(new SyncSingleObject($domain, $object));
        } catch (Exception $ex) {
            return response(['message' => $ex->getMessage()]);
        }

        return response()->turbolinks(route('domains.objects.attributes.index', [$domain, $object]));
    }
}

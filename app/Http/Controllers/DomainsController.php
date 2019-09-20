<?php

namespace App\Http\Controllers;

use App\LdapDomain;
use Illuminate\Support\Str;
use App\Http\Requests\LdapDomainRequest;

class DomainsController extends Controller
{
    /**
     * Displays a list of configured connections.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $domains = LdapDomain::withCount('objects')->get();

        return view('domains.index', compact('domains'));
    }

    /**
     * Displays the form for creating the connection.
     *
     * @param LdapDomain $domain
     *
     * @return \Illuminate\View\View
     */
    public function create(LdapDomain $domain)
    {
        return view('domains.create', compact('domain'));
    }

    /**
     * Create a new LDAP connection.
     *
     * @param LdapDomainRequest $request
     * @param LdapDomain        $domain
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LdapDomainRequest $request, LdapDomain $domain)
    {
        $domain->creator()->associate($request->user());

        $domain->type = $request->type;
        $domain->name = $request->name;
        $domain->slug = Str::slug($request->name);
        $domain->hosts = explode(',', $request->hosts);
        $domain->port = $request->port;
        $domain->base_dn = $request->base_dn;
        $domain->username = $request->username;
        $domain->password = $request->password;
        $domain->save();

        flash()->success('Added LDAP domain.');

        return redirect()->route('domains.index');
    }

    /**
     * Displays the LDAP domain.
     *
     * @param LdapDomain $domain
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(LdapDomain $domain)
    {
        $objects = $domain->objects()
            ->orderBy('name')
            ->paginate(25);

        return view('domains.show', compact('domain', 'objects'));
    }

    public function edit()
    {
        //
    }

    public function update()
    {
        //
    }

    public function destroy()
    {
        //
    }
}

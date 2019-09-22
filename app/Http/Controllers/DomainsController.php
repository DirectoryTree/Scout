<?php

namespace App\Http\Controllers;

use App\LdapDomain;
use App\Jobs\SynchronizeDomain;
use Illuminate\Support\Facades\Bus;
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
        $request->persist($domain);

        flash()->success('Added LDAP domain.');

        return redirect()->route('domains.index');
    }

    /**
     * Displays the LDAP domain.
     *
     * @param LdapDomain $domain
     *
     * @return \Illuminate\View\View
     */
    public function show(LdapDomain $domain)
    {
        return view('domains.show', compact('domain'));
    }

    /**
     * Displays the form for editing the
     *
     * @param LdapDomain $domain
     *
     * @return \Illuminate\View\View
     */
    public function edit(LdapDomain $domain)
    {
        return view('domains.edit', compact('domain'));
    }

    /**
     * Update the LDAP domain.
     *
     * @param LdapDomainRequest $request
     * @param LdapDomain        $domain
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(LdapDomainRequest $request, LdapDomain $domain)
    {
        $request->persist($domain);

        flash()->success('Updated LDAP domain.');

        return redirect()->route('domains.show', $domain);
    }

    /**
     * Queues the synchronization of the domain.
     *
     * @param LdapDomain $domain
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function synchronize(LdapDomain $domain)
    {
        Bus::dispatch(new SynchronizeDomain($domain));

        flash()->success('Queued Synchronization.');

        return redirect()->route('domains.show', $domain);
    }

    /**
     * Deletes the domain and all of its data.
     *
     * @param LdapDomain $domain
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function destroy(LdapDomain $domain)
    {
        $domain->delete();

        flash()->success('Removed domain and all data.');

        return redirect()->route('domains.index');
    }
}

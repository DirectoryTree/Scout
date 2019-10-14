<?php

namespace App\Http\Controllers;

use App\LdapDomain;
use App\Jobs\QueueSync;
use AdSystemNotifierSeeder;
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

        if ($domain->type == LdapDomain::TYPE_ACTIVE_DIRECTORY) {
            (new AdSystemNotifierSeeder())->run();
        }

        return response()->turbolinks(route('domains.show', $domain));
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
        $synchronizedAt = $domain->scans()->latest()->first();

        $changesToday = $domain->objects()->withCount(['changes' => function ($query) {
            $query->whereBetween('ldap_updated_at', [now()->subDay(), now()]);
        }])->get()->sum('changes_count');

        return view('domains.show', compact('domain', 'synchronizedAt', 'changesToday'));
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

        return response()->turbolinks(route('domains.show', $domain));
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
        Bus::dispatch(new QueueSync($domain));

        return response()->turbolinks(route('domains.show', $domain));
    }

    /**
     * Displays the form for deleting a domain.
     *
     * @param LdapDomain $domain
     *
     * @return \Illuminate\View\View
     */
    public function delete(LdapDomain $domain)
    {
        return view('domains.delete', compact('domain'));
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

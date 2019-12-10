<?php

namespace App\Http\Controllers;

use App\Scout;
use App\LdapDomain;
use AdSystemNotifierSeeder;
use App\Http\Requests\LdapDomainRequest;
use Illuminate\Support\Facades\Artisan;

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
     * @return \App\Http\ScoutResponse
     */
    public function store(LdapDomainRequest $request, LdapDomain $domain)
    {
        $request->persist($domain);

        if ($domain->type == LdapDomain::TYPE_ACTIVE_DIRECTORY) {
            (new AdSystemNotifierSeeder())->run();
        }

        // Initialize a new scan for the newly added domain.
        Artisan::call('scout:sync');

        return Scout::response()
            ->notifyWithMessage('Added domain.')
            ->redirect(route('domains.show', $domain));
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
        $synchronizedAt = $domain->scans()->successful()->latest()->first();

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
     * @return \App\Http\ScoutResponse
     */
    public function update(LdapDomainRequest $request, LdapDomain $domain)
    {
        $request->persist($domain);

        return Scout::response()->notifyWithMessage('Updated domain.');
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
     * @return \App\Http\ScoutResponse
     *
     * @throws \Exception
     */
    public function destroy(LdapDomain $domain)
    {
        $domain->delete();

        return Scout::response()
            ->notifyWithMessage('Deleted domain.')
            ->redirect(route('domains.index'));
    }
}

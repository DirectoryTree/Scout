<?php

namespace App\Http\Controllers;

use App\LdapDomain;
use App\LdapNotifier;
use App\Http\Requests\LdapNotifierRequest;

class DomainNotifiersController
{
    /**
     * Displays all the setup LDAP notifications for the domain.
     *
     * @param LdapDomain $domain
     *
     * @return \Illuminate\View\View
     */
    public function index(LdapDomain $domain)
    {
        $notifiers = $domain->notifiers()->latest()->paginate(25);

        return view('domains.notifiers.index', compact('domain', 'notifiers'));
    }

    /**
     * Displays the form for creating a new domain notifier.
     *
     * @param LdapDomain   $domain
     * @param LdapNotifier $notifier
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(LdapDomain $domain, LdapNotifier $notifier)
    {
        return view('domains.notifiers.create', compact('domain', 'notifier'));
    }

    /**
     * Creates a new domain notifier.
     *
     * @param LdapNotifierRequest $request
     * @param LdapDomain          $domain
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LdapNotifierRequest $request, LdapDomain $domain)
    {
        $request->persist(new LdapNotifier(), $domain);

        flash()->success('Added domain notifier');

        return redirect()->route('domains.notifiers.index', $domain);
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

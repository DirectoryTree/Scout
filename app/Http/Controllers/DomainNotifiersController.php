<?php

namespace App\Http\Controllers;

use App\LdapDomain;
use App\LdapNotifier;

class DomainNotifiersController extends Controller
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
        $notifiers = $domain->notifiers()
            ->withCount('conditions')
            ->custom()
            ->latest()
            ->paginate(10);

        $systemNotifiers = $domain->notifiers()->system()->get();

        return view('domains.notifiers.index', compact('domain', 'notifiers', 'systemNotifiers'));
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
     * Displays the notifier belonging to the domain.
     *
     * @param LdapDomain $domain
     * @param integer    $notifierId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(LdapDomain $domain, $notifierId)
    {
        /** @var LdapNotifier $notifier */
        $notifier = $domain->notifiers()->findOrFail($notifierId);

        $conditions = $notifier->conditions()->get();

        return view('domains.notifiers.show', compact('domain', 'notifier', 'conditions'));
    }

    /**
     * Displays the form for editing the domain notifier.
     *
     * @param LdapDomain $domain
     * @param string     $notifierId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(LdapDomain $domain, $notifierId)
    {
        $notifier = $domain->notifiers()->findOrFail($notifierId);

        return view('domains.notifiers.edit', compact('domain', 'notifier'));
    }
}

<?php

namespace App\Http\Controllers;

use App\LdapDomain;

class DomainNotifierConditionsController extends Controller
{
    /**
     * Display the domain notifier conditions.
     *
     * @param LdapDomain $domain
     * @param string     $notifierId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(LdapDomain $domain, $notifierId)
    {
        $notifier = $domain->notifiers()->findOrFail($notifierId);

        return view('domains.notifiers.conditions.index', compact('domain', 'notifier'));
    }
}

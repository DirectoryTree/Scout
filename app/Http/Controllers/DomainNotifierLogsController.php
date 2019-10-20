<?php

namespace App\Http\Controllers;

use App\LdapDomain;

class DomainNotifierLogsController extends Controller
{
    /**
     * Displays a list of all the notifiers logs.
     *
     * @param LdapDomain $domain
     * @param string     $notifierId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(LdapDomain $domain, $notifierId)
    {
        /** @var \App\LdapNotifier $notifier */
        $notifier = $domain->notifiers()->findOrFail($notifierId);

        $logs = $notifier->logs()->latest()->paginate(15);

        return view('domains.notifiers.logs.index', compact('domain', 'notifier', 'logs'));
    }

    public function show(LdapDomain $domain, $notifierId)
    {
        //
    }
}

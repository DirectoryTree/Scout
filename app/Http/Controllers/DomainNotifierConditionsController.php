<?php

namespace App\Http\Controllers;

use App\LdapDomain;
use App\LdapNotifierCondition;
use App\Http\Requests\LdapNotifierConditionRequest;

class DomainNotifierConditionsController extends Controller
{
    /**
     * Create a new notifier condition.
     *
     * @param LdapNotifierConditionRequest $request
     * @param LdapDomain                   $domain
     * @param string                       $notifierId
     *
     * @return mixed
     */
    public function store(LdapNotifierConditionRequest $request, LdapDomain $domain, $notifierId)
    {
        $notifier = $domain->notifiers()->findOrFail($notifierId);

        $request->persist($notifier, new LdapNotifierCondition());

        return redirect()->turbolinks(route('domain.notifiers.edit', [$domain, $notifier]));
    }
}


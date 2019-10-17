<?php

namespace App\Http\Controllers;

use App\LdapDomain;
use App\LdapNotifier;
use App\LdapNotifierCondition;
use App\Http\Requests\LdapNotifierConditionRequest;

class NotifierConditionsController extends Controller
{
    /**
     * Create a new notifier condition.
     *
     * @param LdapNotifierConditionRequest $request
     * @param LdapNotifier                 $notifier
     *
     * @return mixed
     */
    public function store(LdapNotifierConditionRequest $request, LdapNotifier $notifier)
    {
        $request->persist($notifier, new LdapNotifierCondition());

        return redirect()->turbolinks(route('domain.notifiers.edit', [$domain, $notifier]));
    }
}


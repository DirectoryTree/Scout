<?php

namespace App\Http\Controllers;

use App\Scout;
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
        $condition = new LdapNotifierCondition();
        $condition->notifier()->associate($notifier);

        $request->persist($condition);

        return Scout::response()
            ->notifyWithMessage('Created condition.')
            ->redirect(url()->previous());
    }
}

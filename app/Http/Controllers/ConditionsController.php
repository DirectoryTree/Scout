<?php

namespace App\Http\Controllers;

use App\Scout;
use App\LdapNotifierCondition;
use App\Http\Requests\LdapNotifierConditionRequest;

class ConditionsController extends Controller
{
    /**
     * Update an LDAP notifier condition.
     *
     * @param LdapNotifierConditionRequest $request
     * @param LdapNotifierCondition        $condition
     *
     * @return \App\Http\ScoutResponse
     */
    public function update(LdapNotifierConditionRequest $request, LdapNotifierCondition $condition)
    {
        $request->persist($condition);

        return Scout::response()
            ->notifyWithMessage('Updated condition.')
            ->redirect(url()->previous());
    }

    /**
     * Delete an LDAP notifier condition.
     *
     * @param LdapNotifierCondition $condition
     *
     * @return \App\Http\ScoutResponse
     *
     * @throws \Exception
     */
    public function destroy(LdapNotifierCondition $condition)
    {
        /** @var \App\LdapNotifier $notifier */
        $notifier = $condition->notifier()->firstOrFail();

        $condition->delete();

        // Disable the notifier when no more conditions exist.
        if (!$notifier->conditions()->exists()) {
            $notifier->enabled = false;
            $notifier->save();
        }

        return Scout::response()
            ->notifyWithMessage('Deleted condition.')
            ->redirect(url()->previous());
    }
}

<?php

namespace App\Http\Controllers;

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
     * @return mixed
     */
    public function update(LdapNotifierConditionRequest $request, LdapNotifierCondition $condition)
    {
        $request->persist($condition);

        return response()->turbolinks(url()->previous());
    }

    /**
     * Delete an LDAP notifier condition.
     *
     * @param LdapNotifierCondition $condition
     *
     * @return mixed
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

        return response()->turbolinks(url()->previous());
    }
}

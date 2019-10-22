<?php

namespace App\Http\Controllers;

use App\Scout;
use App\LdapNotifier;
use App\Http\Requests\LdapNotifierRequest;

class NotifiersController
{
    /**
     * Update the LDAP notifier.
     *
     * @param LdapNotifierRequest $request
     * @param LdapNotifier        $notifier
     *
     * @return \App\Http\ScoutResponse
     */
    public function update(LdapNotifierRequest $request, LdapNotifier $notifier)
    {
        $request->persist($notifier);

        return Scout::response()
            ->notifyWithMessage('Updated notifier.')
            ->redirect(url()->previous());
    }

    /**
     * Delete the LDAP notifier.
     *
     * @param LdapNotifier $notifier
     *
     * @return \App\Http\ScoutResponse
     *
     * @throws \Exception
     */
    public function destroy(LdapNotifier $notifier)
    {
        $notifier->delete();

        return Scout::response()
            ->notifyWithMessage('Deleted notifier.')
            ->redirect(url()->previous());
    }
}

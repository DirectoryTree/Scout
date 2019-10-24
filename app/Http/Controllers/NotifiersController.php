<?php

namespace App\Http\Controllers;

use App\Scout;
use App\LdapNotifier;
use App\Http\Requests\LdapNotifierRequest;

class NotifiersController extends Controller
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
        $this->authorize('notifier.edit', $notifier);

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
        $this->authorize('notifier.delete', $notifier);

        $notifier->delete();

        return Scout::response()
            ->notifyWithMessage('Deleted notifier.')
            ->redirect(url()->previous());
    }
}

<?php

namespace App\Http\Controllers;

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
     * @return mixed
     */
    public function update(LdapNotifierRequest $request, LdapNotifier $notifier)
    {
        $request->persist($notifier);

        return response()->turbolinks(url()->previous());
    }

    /**
     * Delete the LDAP notifier.
     *
     * @param LdapNotifier $notifier
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function destroy(LdapNotifier $notifier)
    {
        $notifier->delete();

        return response()->turbolinks(url()->previous());
    }
}

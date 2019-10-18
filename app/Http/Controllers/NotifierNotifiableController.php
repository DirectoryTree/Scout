<?php

namespace App\Http\Controllers;

use App\LdapNotifier;
use App\Http\Requests\LdapNotifierRequest;

class NotifierNotifiableController
{
    /**
     * Creates a new domain notifier.
     *
     * @param LdapNotifierRequest                 $request
     * @param string                              $notifiableType
     * @param \Illuminate\Database\Eloquent\Model $notifiableModel
     *
     * @return \Illuminate\Http\Response
     */
    public function store(LdapNotifierRequest $request, $notifiableType, $notifiableModel)
    {
        $notifier = new LdapNotifier();
        $notifier->notifiable()->associate($notifiableModel);

        $request->persist($notifier);

        return response()->turbolinks(url()->previous());
    }
}

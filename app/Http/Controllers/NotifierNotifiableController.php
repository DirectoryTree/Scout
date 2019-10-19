<?php

namespace App\Http\Controllers;

use App\Scout;
use App\LdapDomain;
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
     * @return \App\Http\ScoutResponse
     */
    public function store(LdapNotifierRequest $request, $notifiableType, $notifiableModel)
    {
        $notifier = new LdapNotifier();
        $notifier->notifiable()->associate($notifiableModel);

        $request->persist($notifier);

        $url = $notifiableModel instanceof LdapDomain ?
            route('domains.notifiers.edit', [$notifiableModel, $notifier]) :
            url()->previous();

        return Scout::response()
            ->notifyWithMessage('Created notifier.')
            ->redirect($url);
    }
}

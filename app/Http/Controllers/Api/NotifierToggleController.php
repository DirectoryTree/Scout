<?php

namespace App\Http\Controllers\Api;

use App\LdapNotifier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotifierToggleController extends Controller
{
    /**
     * Toggles the notifiers enablement.
     *
     * @param LdapNotifier $notifier
     * @param Request      $request
     *
     * @return array
     */
    public function update(LdapNotifier $notifier, Request $request)
    {
        $this->validate($request, ['enabled' => 'boolean']);

        $notifier->enabled = $request->enabled;
        $notifier->save();

        return ['saved' => true];
    }
}

<?php

namespace App\Http\Controllers;

use App\Scout;
use Illuminate\Http\Request;

class NotificationMarkAllController extends Controller
{
    /**
     * Marks all the users notifications as read.
     *
     * @param Request $request
     *
     * @return \App\Http\ScoutResponse
     */
    public function update(Request $request)
    {
        $request->user()->unreadNotifications()->update(['read_at' => now()]);

        return Scout::response()->visit(url()->previous());
    }
}

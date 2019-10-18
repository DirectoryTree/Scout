<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationMarkController extends Controller
{
    /**
     * Marks a user notification as read.
     *
     * @param Request $request
     * @param string  $notificationId
     *
     * @return mixed
     */
    public function update(Request $request, $notificationId)
    {
        $this->validate($request, ['read' => 'boolean']);

        /** @var \Illuminate\Notifications\DatabaseNotification $notification */
        $notification = $request->user()->notifications()->findOrFail($notificationId);

        $request->read ? $notification->markAsRead() : $notification->markAsUnread();

        return response()->turbolinks(url()->previous());
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{
    /**
     * Displays all notifications.
     *
     * @param Request $request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = DatabaseNotification::with('notifiable');

        if ($request->get('unread', 'yes') == 'yes') {
            $query->whereNull('read_at');
        } else {
            $query->whereNotNull('read_at');
        }

        $notifications = $query->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    public function show(LdapNotifier $notifier)
    {
        //
    }
}

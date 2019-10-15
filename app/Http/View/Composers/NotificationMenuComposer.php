<?php

namespace App\Http\View\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Notifications\DatabaseNotification;

class NotificationMenuComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with([
            'counts' => [
                'read' => DatabaseNotification::whereNotNull('read_at')->count(),
                'unread' => DatabaseNotification::whereNull('read_at')->count(),
            ]
        ]);
    }
}

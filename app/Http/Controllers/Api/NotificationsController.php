<?php

namespace App\Http\Controllers\Api;

use App\Notifications;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NotificationsController
{
    /**
     * The number of seconds to wait until refreshing the clients data.
     *
     * @var int
     */
    protected $refreshInterval = 15;

    /**
     * Returns the notification event stream.
     *
     * @param Request $request
     *
     * @return StreamedResponse
     */
    public function index(Request $request)
    {
        return new StreamedResponse(function() use ($request) {
            while(true) {
                $notifications = (new Notifications($request->user()))->get()->transform(function ($notification) {
                    return view('notifications.notification', compact('notification'))->render();
                });

                echo 'data: ' . $notifications . "\n\n";
                ob_flush();
                flush();

                sleep($this->refreshInterval);
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'X-Accel-Buffering' => 'no',
            'Cache-Control' => 'no-cache',
        ]);
    }
}

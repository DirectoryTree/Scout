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
    protected $refreshInterval = 10;

    /**
     * Returns the notification event stream.
     *
     * @param Request $request
     *
     * @return StreamedResponse
     */
    public function index(Request $request)
    {
        $notifications = new Notifications($request->user());

        return new StreamedResponse(function() use ($notifications) {
            while(true) {
                echo 'data: ' . json_encode($notifications->resource()) . "\n\n";
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

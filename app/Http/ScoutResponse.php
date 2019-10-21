<?php

namespace App\Http;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Support\Responsable;

class ScoutResponse implements Responsable
{
    /**
     * The base JSON response.
     *
     * @var \Illuminate\Http\JsonResponse
     */
    protected $response;

    /**
     * The default response data.
     *
     * @var array
     */
    protected $default = [
        'type' => 'success',
        'message' => '',
        'notify' => false,
    ];

    /**
     * Create a new scout response.
     *
     * @param array $data
     * @param int   $status
     * @param array $headers
     */
    public function __construct(array $data = [], $status = 200, array $headers = [])
    {
        $this->response = Response::json(array_merge($this->default, $data), $status, $headers);
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return $this->response;
    }

    /**
     * Set the response type.
     *
     * @param string $type
     *
     * @return $this
     */
    public function type($type)
    {
        switch ($type) {
            case 'success':
                $this->response->setStatusCode(200);
                break;
            default:
                $this->response->setStatusCode(500);
                break;
        }

        return $this->mergeResponseData(['type' => $type]);
    }

    /**
     * Render the view into the response without redirection or navigation.
     *
     * @param View $view
     *
     * @return $this
     */
    public function render(View $view)
    {
        return $this->html($view->render())->mergeResponseData(['render' => true]);
    }

    /**
     * Add HTML to the response.
     *
     * @param string $html
     *
     * @return $this
     */
    public function html($html)
    {
        return $this->mergeResponseData(['html' => $html]);
    }

    /**
     * The container to render the HTML response into.
     *
     * @param string $container The ID of the container to render the HTML into.
     *
     * @return ScoutResponse
     */
    public function into($container)
    {
        return $this->mergeResponseData(['container' => $container]);
    }

    /**
     * Whether the user should be notified of the message.
     *
     * @return $this
     */
    public function notify()
    {
        return $this->mergeResponseData(['notify' => true]);
    }

    /**
     * Set the response message.
     *
     * @param string $message
     *
     * @return $this
     */
    public function message($message)
    {
        return $this->mergeResponseData(['message' => $message]);
    }

    /**
     * Notify the user with the given message.
     *
     * @param string $message
     *
     * @return $this
     */
    public function notifyWithMessage($message)
    {
        return $this->notify()->message($message);
    }

    /**
     * Clear the turbolinks cache.
     *
     * @return $this
     */
    public function withoutCache()
    {
        return $this->mergeResponseData(['cache' => false]);
    }

    /**
     * Set the URL to visit.
     *
     * @param string $url
     *
     * @return $this
     */
    public function visit($url)
    {
        return $this->url($url, false);
    }

    /**
     * Set the redirect URL.
     *
     * @param string $url
     *
     * @return $this
     */
    public function redirect($url)
    {
        return $this->url($url, true);
    }

    /**
     * Set the URL to redirect / visit.
     *
     * @param string $url
     * @param bool   $redirect
     *
     * @return $this
     */
    public function url($url, $redirect = true)
    {
        return $this->mergeResponseData([
            'url' => $url,
            'redirect' => $redirect,
        ]);
    }

    /**
     * Merges the response data.
     *
     * @param array $data
     *
     * @return $this
     */
    protected function mergeResponseData(array $data = [])
    {
        $this->response->setData(
            array_merge($this->response->getData($assoc = true), $data)
        );

        return $this;
    }
}

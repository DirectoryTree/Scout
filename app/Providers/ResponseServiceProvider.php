<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register the response macros.
     *
     * @param ResponseFactory $factory
     */
    public function boot(ResponseFactory $factory)
    {
        Response::macro('turbolinks', function ($url, $replace = false) use ($factory) {
            $action = $replace ? 'replace' : 'advance';

            $script = [
                'Turbolinks.clearCache()',
                "Turbolinks.visit('{$url}', {'action':'{$action}'})",
            ];

            return $factory->make(implode("\n", $script), 200)
                ->header('Content-Type', 'application/javascript');
        });
    }
}

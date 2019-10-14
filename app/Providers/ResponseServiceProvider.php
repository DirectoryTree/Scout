<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

class ResponseServiceProvider extends ServiceProvider
{
    public function boot(ResponseFactory $factory)
    {
        Response::macro('turbolinks', function ($url) use ($factory) {
            $script = [];
            $script[] = 'Turbolinks.clearCache()';
            $script[] = sprintf('Turbolinks.visit("%s", {"action":"replace"})', $url);

            return $factory->make(implode("\n", $script), 200)
                ->header('Content-Type', 'application/javascript')
                ->setStatusCode(200);
        });
    }
}

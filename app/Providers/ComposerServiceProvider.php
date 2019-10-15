<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\AppLayoutComposer;
use App\Http\View\Composers\DomainFormComposer;
use App\Http\View\Composers\InstallFormComposer;
use App\Http\View\Composers\DomainLayoutComposer;
use App\Http\View\Composers\NotifierFormComposer;
use App\Http\View\Composers\NotificationMenuComposer;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * The view composer map.
     *
     * @var array
     */
    protected $composers = [
        AppLayoutComposer::class => ['layouts.app'],
        DomainFormComposer::class => ['domains.form'],
        DomainLayoutComposer::class => ['domains.layout'],
        NotifierFormComposer::class => ['domains.notifiers.form'],
        InstallFormComposer::class => ['installer.form'],
        NotificationMenuComposer::class => ['notifications.menu'],
    ];

    /**
     * Bootstrap the view composers.
     */
    public function boot()
    {
        foreach ($this->composers as $composer => $views) {
            View::composer($views, $composer);
        }
    }
}

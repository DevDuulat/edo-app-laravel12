<?php

namespace App\Providers;

use App\Services\IncomingDocumentService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
    }

    public function boot(): void
    {
        View::composer('components.layouts.app.sidebar', function ($view) {
            $incomingCount = app(IncomingDocumentService::class)->countIncomingDocuments();
            $view->with('incomingCount', $incomingCount);
        });

//        Выключить в проде
//        Включить локально
        URL::forceScheme('https');
    }
}

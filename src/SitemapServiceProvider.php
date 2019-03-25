<?php

namespace Ably\Sitemap;

use Ably\Sitemap\Console\Commands\ClearSitemapsCommand;
use Ably\Sitemap\Console\Commands\GenerateSitemapCommand;
use Illuminate\Support\ServiceProvider;

class SitemapServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/sitemap.php', 'sitemap'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sitemap.php' => config_path('sitemap.php'),
        ]);
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'sitemap');

        $this->loadRoutesFrom(__DIR__.'/../config/routes.php');

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateSitemapCommand::class,
                ClearSitemapsCommand::class
            ]);
        }

    }
}

<?php

namespace Ably\Sitemap;

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
    }
}

<?php

Route::namespace('Ably\\Sitemap\\Http\\Controllers')->group(function (){
    Route::get(config('sitemap.stylesheet_uri'), 'SitemapStylesheetController@show')->name('sitemap:stylesheet');

    Route::get(config('sitemap.sitemap_uri'), 'SitemapsController@show');
    Route::get(config('sitemap.sitemap_index_uri'), 'SitemapsController@show');
});

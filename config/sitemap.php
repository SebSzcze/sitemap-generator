<?php

return  [

    'storage' => [
        'disk' => 'local', 
        'path' => 'sitemaps'
    ],
    'chunk_size' => 1000,
    'models' => [
        \App\Models\Post::class,
        \App\Models\Page::class,
//        \App\Models\Category::class,
//        \App\Models\PostTag::class,
        \App\Models\Startup::class,
    ],

    'stylesheet_uri' => 'sitemap-stylesheet.xsl',
    'sitemap_index_uri' => 'sitemap.xml',
    'sitemap_uri' =>  '{model}-sitemap-{chunk}'
];

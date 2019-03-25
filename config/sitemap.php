<?php

return  [
    'storage' => [
        'disk' => 'local', 
        'path' => 'sitemaps'
    ],
    'chunk_size' => 1000,
    'models' => [],
    'stylesheet_uri' => 'sitemap-stylesheet.xsl',
    'sitemap_index_uri' => 'sitemap.xml',
    'sitemap_uri' =>  '{model}-sitemap-{chunk}'
];

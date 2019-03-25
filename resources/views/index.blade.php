<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="{{ route('sitemap:stylesheet') }}"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($items as $group)
        @foreach($group as $item)
            @include('sitemap::sitemap-item', ['item' => $item ])
        @endforeach
    @endforeach 
</sitemapindex>

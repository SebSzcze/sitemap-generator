<url>
    <loc>{{ url($item->getUrl()) }}</loc>
    <lastmod>{{ $item->getModificationDate() }}</lastmod>
    @foreach($item->getSitemapsImages() as $image)
        <image:image>
            <image:loc>{{ asset($image) }}</image:loc>
        </image:image>
    @endforeach
</url>

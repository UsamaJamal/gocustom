<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
@foreach ($entries as $entry)
    <url>
        <loc>{{ $entry['loc'] }}</loc>
@if (!empty($entry['lastmod']))
        <lastmod>{{ $entry['lastmod'] }}</lastmod>
@endif
@if (!empty($entry['changefreq']))
        <changefreq>{{ $entry['changefreq'] }}</changefreq>
@endif
@if (!empty($entry['priority']))
        <priority>{{ $entry['priority'] }}</priority>
@endif
@foreach ($entry['images'] as $image)
        <image:image>
            <image:loc>{{ is_array($image) ? $image['loc'] : $image }}</image:loc>
@if (is_array($image) && !empty($image['title']))
            <image:title>{{ $image['title'] }}</image:title>
@endif
@if (is_array($image) && !empty($image['caption']))
            <image:caption>{{ $image['caption'] }}</image:caption>
@endif
        </image:image>
@endforeach
    </url>
@endforeach
</urlset>

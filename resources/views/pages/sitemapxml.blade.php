<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->toDateString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ url('/about') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('/services') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('/projects') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('/blogs') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>{{ url('/contact') }}</loc>
        <changefreq>yearly</changefreq>
        <priority>0.5</priority>
    </url>

    @foreach ($posts as $post)
        <url>
            <loc>{{ url($post->slug) }}</loc>
            <lastmod>{{ $post->updated_at->toDateString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach


    @foreach ($projects as $project)
    <url>
        <loc>{{ url('project/' . urlencode(strtolower(str_replace(' ', '-', $project['title'])))) }}</loc>
        {{-- <lastmod>{{ now()->toDateString() }}</lastmod> --}} {{-- Optional fallback --}}
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach

</urlset>

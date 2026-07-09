<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">


    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>2023-01-15T14:16:16+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/home') }}</loc>
        <lastmod>2023-01-15T14:16:16+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/about') }}</loc>
        <lastmod>2023-01-15T14:16:16+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/get-services') }}</loc>
        <lastmod>2023-01-15T14:16:16+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/service/website') }}</loc>
        <lastmod>2023-01-15T14:16:16+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/service/marketing') }}</loc>
        <lastmod>2023-01-15T14:16:16+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/service/SEO') }}</loc>
        <lastmod>2023-01-15T14:16:16+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/service/support') }}</loc>
        <lastmod>2023-01-15T14:16:16+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/get-products') }}</loc>
        <lastmod>2023-01-15T14:16:16+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

{{--     <url>
        <loc>{{ url('/blog-script') }}</loc>
        <lastmod>2023-01-15T14:16:16+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url> --}}



    <url>
        <loc>{{ url('/projects') }}</loc>
        <lastmod>2023-01-15T14:16:16+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/faq') }}</loc>
        <lastmod>2023-01-15T14:16:16+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/testimonial') }}</loc>
        <lastmod>2023-01-15T14:16:16+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/customer-service') }}</loc>
        <lastmod>2023-01-15T14:16:16+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/buy-now') }}</loc>
        <lastmod>2023-01-15T14:16:16+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/get-quote') }}</loc>
        <lastmod>2023-01-15T14:16:16+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    
    <url>
        <loc>{{ url('/blogs') }}</loc>
        <lastmod>2023-01-15T14:16:16+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    @foreach ($blogs as $blog)
    <?php $category = str_replace(" ", "-", $blog->name); ?>
        <url>
            <loc>{{ url('/') }}/{{ $category.'/'.$blog->slug }}</loc>
            <lastmod>{{ $blog->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>
<div id="panel-sitemap-robots" class="tab-panel space-y-6 {{ request('tab') !== 'sitemap-robots' ? 'hidden' : '' }}">
    <div class="grid lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
            <div class="flex items-center justify-between mb-1">
                <h2 class="font-bold text-sm">Sitemap Generator</h2>
                @if ($sitemap['last_generated_at'])
                    <span class="bg-success/10 text-success text-[11px] font-semibold px-2.5 py-1 rounded-full">Up to date</span>
                @else
                    <span class="bg-black/5 text-black/45 text-[11px] font-semibold px-2.5 py-1 rounded-full">Not generated</span>
                @endif
            </div>
            <p class="text-black/40 text-xs mb-5">
                @if ($sitemap['last_generated_at'])
                    Last generated {{ \Illuminate\Support\Carbon::parse($sitemap['last_generated_at'])->diffForHumans() }} &middot; {{ $sitemap['url_count'] }} URLs
                @else
                    Not generated yet.
                @endif
            </p>

            <form method="POST" action="{{ route('admin.cms.seo.sitemap.regenerate') }}">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 bg-ink text-white text-sm font-semibold px-5 py-2.5 rounded-full hover:bg-black/80 transition mb-5">
                    <i class="fa-solid fa-arrows-rotate text-xs"></i> Regenerate Sitemap
                </button>
            </form>

            <p class="text-xs font-semibold text-black/50 mb-2">sitemap.xml preview</p>
            <div class="bg-black/[0.03] rounded-xl p-4 font-mono text-xs text-black/60 overflow-x-auto">
                <pre class="whitespace-pre">@foreach ($sitemapPreview as $url)&lt;url&gt;
  &lt;loc&gt;{{ $url['loc'] }}&lt;/loc&gt;
  &lt;lastmod&gt;{{ $url['lastmod'] }}&lt;/lastmod&gt;
  &lt;changefreq&gt;{{ $url['changefreq'] }}&lt;/changefreq&gt;
  &lt;priority&gt;{{ $url['priority'] }}&lt;/priority&gt;
&lt;/url&gt;
@endforeach</pre>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
            <div class="flex items-center justify-between mb-1">
                <h2 class="font-bold text-sm">Robots.txt Editor</h2>
                <span class="bg-success/10 text-success text-[11px] font-semibold px-2.5 py-1 rounded-full"><i class="fa-solid fa-circle-check text-[9px] mr-1"></i>Valid syntax</span>
            </div>
            <p class="text-black/40 text-xs mb-5">Controls which crawlers can access parts of your store.</p>

            <form method="POST" action="{{ route('admin.cms.seo.robots.update') }}">
                @csrf @method('PUT')
                <label for="robotsTxt" class="sr-only">robots.txt content</label>
                <textarea id="robotsTxt" name="robots_txt" rows="10" class="w-full px-4 py-3 rounded-xl border border-black/10 bg-black/[0.02] font-mono text-xs focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition resize-none">{{ $robotsTxt }}</textarea>

                <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-black/5">
                    <button type="submit" class="text-sm font-semibold px-6 py-2.5 rounded-full bg-ink text-white hover:bg-black/80 transition">Save robots.txt</button>
                </div>
            </form>
        </div>

    </div>
</div>

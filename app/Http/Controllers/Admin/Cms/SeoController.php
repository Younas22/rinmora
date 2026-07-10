<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\Cms\Media;
use App\Models\Cms\NotFoundLog;
use App\Models\Cms\Redirect;
use App\Models\Cms\SeoMeta;
use App\Models\Setting;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    protected const ROBOTS_DEFAULT = <<<'TXT'
        User-agent: *
        Disallow: /admin
        Disallow: /cart
        Disallow: /checkout
        Disallow: /account
        Allow: /

        User-agent: Googlebot
        Allow: /

        Sitemap: https://rinmora.com/sitemap.xml
        TXT;

    public function index(Request $request)
    {
        $seoMetas = SeoMeta::orderBy('page_label')->get();
        $filter = $request->get('filter', 'all');
        $filteredMetas = $filter === 'all' ? $seoMetas : $seoMetas->where('page_type', $filter)->values();

        $stats = [
            'avg_score' => (int) round($seoMetas->avg('seo_score') ?? 0),
            'indexed_pages' => $seoMetas->count(),
            'broken_links' => NotFoundLog::count(),
            'title_ok' => $seoMetas->where('meta_title_ok', true)->count(),
            'desc_ok' => $seoMetas->where('meta_description_ok', true)->count(),
            'missing_alt' => Media::where('type', 'image')->whereNull('alt_text')->count(),
        ];

        $redirects = Redirect::latest()->paginate(10)->withQueryString();
        $notFoundLogs = NotFoundLog::orderByDesc('hit_count')->get();

        $robotsTxt = Setting::getValue('robots_txt', 'seo', self::ROBOTS_DEFAULT);
        $sitemap = [
            'last_generated_at' => Setting::getValue('sitemap_last_generated_at', 'seo'),
            'url_count' => (int) Setting::getValue('sitemap_url_count', 'seo', 0),
        ];
        $sitemapPreview = $this->sitemapPreviewUrls();

        $selectedPageUrl = $request->get('page', optional($seoMetas->first())->page_url);
        $selectedMeta = $seoMetas->firstWhere('page_url', $selectedPageUrl) ?: $seoMetas->first();

        $prefillFrom = session('prefill_from');

        return view('admin.cms.seo.index', compact(
            'seoMetas', 'filter', 'filteredMetas', 'stats', 'redirects', 'notFoundLogs',
            'robotsTxt', 'sitemap', 'sitemapPreview', 'selectedMeta', 'prefillFrom'
        ));
    }

    public function updateMeta(Request $request, SeoMeta $seoMeta)
    {
        $data = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'focus_keyword' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|string|max:255',
            'twitter_card_type' => 'required|in:summary_large_image,summary',
            'og_image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('og_image')) {
            $data['og_image_path'] = $request->file('og_image')->store('cms/seo', 'public_uploads');
        }
        unset($data['og_image']);

        $seoMeta->update($data);

        return redirect()->route('admin.cms.seo.index', ['tab' => 'meta-editor', 'page' => $seoMeta->page_url])
            ->with('success', 'Meta updated.');
    }

    public function updateRobots(Request $request)
    {
        $request->validate(['robots_txt' => 'required|string']);

        Setting::setValue('robots_txt', $request->robots_txt, 'seo');

        return redirect()->route('admin.cms.seo.index', ['tab' => 'sitemap-robots'])->with('success', 'robots.txt saved.');
    }

    public function regenerateSitemap(Request $request)
    {
        $count = 1 + Product::count() + Category::count();

        Setting::setValue('sitemap_last_generated_at', now()->toDateTimeString(), 'seo');
        Setting::setValue('sitemap_url_count', $count, 'seo');

        return redirect()->route('admin.cms.seo.index', ['tab' => 'sitemap-robots'])->with('success', 'Sitemap regenerated.');
    }

    public function storeRedirect(Request $request)
    {
        $data = $request->validate([
            'from_url' => 'required|string|max:255',
            'to_url' => 'required|string|max:255',
            'type' => 'required|in:301,302',
        ]);

        Redirect::create($data);

        return redirect()->route('admin.cms.seo.index', ['tab' => 'redirects'])->with('success', 'Redirect added.');
    }

    public function updateRedirect(Request $request, Redirect $redirect)
    {
        $data = $request->validate([
            'from_url' => 'required|string|max:255',
            'to_url' => 'required|string|max:255',
            'type' => 'required|in:301,302',
            'status' => 'required|in:active,paused',
        ]);

        $redirect->update($data);

        return redirect()->route('admin.cms.seo.index', ['tab' => 'redirects'])->with('success', 'Redirect updated.');
    }

    public function destroyRedirect(Redirect $redirect)
    {
        $redirect->delete();

        return redirect()->route('admin.cms.seo.index', ['tab' => 'redirects'])->with('success', 'Redirect deleted.');
    }

    public function createRedirectFromNotFound(Request $request, NotFoundLog $notFoundLog)
    {
        session()->flash('prefill_from', $notFoundLog->url);

        return redirect()->route('admin.cms.seo.index', ['tab' => 'redirects']);
    }

    public function updateSchema(Request $request, SeoMeta $seoMeta)
    {
        $data = $request->validate([
            'schema_type' => 'nullable|string|max:255',
            'schema_json' => 'nullable|json',
        ]);

        $seoMeta->update($data);

        return redirect()->route('admin.cms.seo.index', ['tab' => 'schema', 'page' => $seoMeta->page_url])
            ->with('success', 'Schema markup saved.');
    }

    protected function sitemapPreviewUrls(): array
    {
        $urls = [
            ['loc' => url('/'), 'lastmod' => now()->toDateString(), 'changefreq' => 'daily', 'priority' => '1.0'],
        ];

        foreach (Product::latest()->take(2)->get() as $product) {
            $urls[] = [
                'loc' => url('/products/'.$product->slug),
                'lastmod' => $product->updated_at->toDateString(),
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ];
        }

        foreach (Category::latest()->take(1)->get() as $category) {
            $urls[] = [
                'loc' => url('/collections/'.$category->slug),
                'lastmod' => $category->updated_at->toDateString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        return $urls;
    }
}

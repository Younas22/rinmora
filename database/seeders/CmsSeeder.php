<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\Cms\EmailLog;
use App\Models\Cms\HomepageSection;
use App\Models\Cms\Media;
use App\Models\Cms\NotFoundLog;
use App\Models\Cms\NotificationCampaign;
use App\Models\Cms\Redirect;
use App\Models\Cms\SeoMeta;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class CmsSeeder extends Seeder
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

    public function run(): void
    {
        $this->seedHomepageSections();
        $this->seedMedia();
        $this->seedSeoMeta();
        Setting::setValue('robots_txt', self::ROBOTS_DEFAULT, 'seo');
        $this->seedRedirects();
        $this->seedNotFoundLogs();
        $this->seedNotificationCampaigns();
        $this->seedEmailLogs();
    }

    protected function seedHomepageSections(): void
    {
        $categoryCount = Category::count();
        $bestSellerCount = Product::inRandomOrder()->limit(8)->count();

        $sections = [
            ['type' => 'hero_slider', 'title' => 'Hero Slider', 'subtitle' => '3 slides', 'button_text' => 'Shop Now', 'button_link' => '/shop', 'is_visible' => true],
            ['type' => 'featured_categories', 'title' => 'Featured Categories', 'subtitle' => "{$categoryCount} categories", 'button_text' => null, 'button_link' => null, 'is_visible' => true],
            ['type' => 'best_sellers', 'title' => 'Best Sellers', 'subtitle' => "{$bestSellerCount} products", 'button_text' => 'View All', 'button_link' => '/best-sellers', 'is_visible' => true],
            ['type' => 'promotional_banner', 'title' => 'Promotional Banner', 'subtitle' => 'New Season Collection', 'button_text' => 'Shop the Edit', 'button_link' => '/collections/new-season', 'is_visible' => true],
            ['type' => 'testimonials', 'title' => 'Testimonials', 'subtitle' => 'Disabled', 'button_text' => null, 'button_link' => null, 'is_visible' => false],
            ['type' => 'newsletter', 'title' => 'Newsletter', 'subtitle' => 'Stay in Style', 'button_text' => 'Subscribe', 'button_link' => null, 'is_visible' => true],
        ];

        foreach ($sections as $i => $section) {
            HomepageSection::firstOrCreate(
                ['type' => $section['type']],
                $section + ['sort_order' => $i + 1]
            );
        }
    }

    protected function seedMedia(): void
    {
        if (Media::count() > 0) {
            return;
        }

        $manager = new ImageManager(new Driver());

        $placeholders = [
            ['name' => 'milano-tote-01.jpg', 'color' => '#CFBAA5', 'folder' => 'products'],
            ['name' => 'luna-crossbody-02.jpg', 'color' => '#8B5A2B', 'folder' => 'products'],
            ['name' => 'aurora-mini-bag-03.jpg', 'color' => '#F5F0E6', 'folder' => 'products'],
            ['name' => 'homepage-banner.jpg', 'color' => '#000000', 'folder' => 'banners'],
            ['name' => 'summer-collection-hero.jpg', 'color' => '#b89e84', 'folder' => 'images'],
        ];

        foreach ($placeholders as $p) {
            $uuid = Str::uuid();
            $path = "cms/media/{$uuid}.jpg";
            $thumbPath = "cms/media/{$uuid}-thumb.jpg";

            $image = $manager->create(1200, 1200)->fill($p['color']);
            $encoded = (string) $image->toJpeg();
            Storage::disk('public_uploads')->put($path, $encoded);

            $thumb = $manager->create(400, 400)->fill($p['color']);
            Storage::disk('public_uploads')->put($thumbPath, (string) $thumb->toJpeg());

            Media::create([
                'path' => $path,
                'thumb_path' => $thumbPath,
                'original_name' => $p['name'],
                'alt_text' => null,
                'mime_type' => 'image/jpeg',
                'size' => strlen($encoded),
                'type' => 'image',
                'folder' => $p['folder'],
            ]);
        }

        // Non-image rows — never rendered as an <img>, folder/type only.
        Media::create([
            'path' => 'cms/media/'.Str::uuid().'.mp4',
            'thumb_path' => null,
            'original_name' => 'brand-campaign-reel.mp4',
            'alt_text' => null,
            'mime_type' => 'video/mp4',
            'size' => 18_400_000,
            'type' => 'video',
            'folder' => 'videos',
        ]);

        Media::create([
            'path' => 'cms/media/'.Str::uuid().'.pdf',
            'thumb_path' => null,
            'original_name' => 'size-guide.pdf',
            'alt_text' => null,
            'mime_type' => 'application/pdf',
            'size' => 340_000,
            'type' => 'document',
            'folder' => 'documents',
        ]);
    }

    protected function seedSeoMeta(): void
    {
        $rows = [
            [
                'page_url' => '/', 'page_label' => 'Home', 'page_type' => 'other',
                'meta_title' => 'Rinmora | Premium Handcrafted Leather Handbags',
                'meta_description' => 'Discover timeless, handcrafted leather handbags designed for the modern woman. Shop totes, crossbody bags, and clutches with free shipping over $150.',
                'focus_keyword' => 'leather handbags', 'canonical_url' => url('/'),
            ],
            [
                'page_url' => '/about', 'page_label' => 'About Us', 'page_type' => 'other',
                'meta_title' => 'About Rinmora', 'meta_description' => null, 'focus_keyword' => null, 'canonical_url' => url('/about'),
            ],
            [
                'page_url' => '/contact', 'page_label' => 'Contact', 'page_type' => 'other',
                'meta_title' => 'Contact Rinmora', 'meta_description' => 'Get in touch with the Rinmora team for order support, wholesale inquiries, and more.',
                'focus_keyword' => null, 'canonical_url' => url('/contact'),
            ],
        ];

        foreach (Product::latest()->take(2)->get() as $product) {
            $rows[] = [
                'page_url' => "/products/{$product->slug}", 'page_label' => "{$product->name} (PDP)", 'page_type' => 'products',
                'meta_title' => "{$product->name} | Rinmora", 'meta_description' => $product->short_description,
                'focus_keyword' => strtolower($product->name), 'canonical_url' => url("/products/{$product->slug}"),
            ];
        }

        if ($category = Category::first()) {
            $rows[] = [
                'page_url' => "/collections/{$category->slug}", 'page_label' => "{$category->name} (Category)", 'page_type' => 'categories',
                'meta_title' => "{$category->name} | Rinmora", 'meta_description' => "Shop the {$category->name} collection at Rinmora.",
                'focus_keyword' => null, 'canonical_url' => url("/collections/{$category->slug}"),
            ];
        }

        if ($post = BlogPost::first()) {
            $rows[] = [
                'page_url' => "/blog/{$post->slug}", 'page_label' => "Blog: {$post->title}", 'page_type' => 'blog',
                'meta_title' => $post->title, 'meta_description' => $post->excerpt,
                'focus_keyword' => null, 'canonical_url' => url("/blog/{$post->slug}"),
            ];
        }

        foreach ($rows as $row) {
            SeoMeta::firstOrCreate(['page_url' => $row['page_url']], $row);
        }
    }

    protected function seedRedirects(): void
    {
        $redirects = [
            ['from_url' => '/old-summer-sale', 'to_url' => '/collections/summer-edit', 'type' => '301', 'hits' => 1204, 'status' => 'active'],
            ['from_url' => '/bags/aurora', 'to_url' => '/products/aurora-mini-bag', 'type' => '301', 'hits' => 892, 'status' => 'active'],
            ['from_url' => '/shop/totes', 'to_url' => '/collections/tote-bags', 'type' => '301', 'hits' => 640, 'status' => 'active'],
            ['from_url' => '/promo/vday2025', 'to_url' => '/collections/gift-edit', 'type' => '302', 'hits' => 318, 'status' => 'active'],
            ['from_url' => '/products/luna-crossbody-old', 'to_url' => '/products/luna-crossbody', 'type' => '301', 'hits' => 215, 'status' => 'active'],
            ['from_url' => '/blog/leather-care-tips', 'to_url' => '/blog/caring-for-leather', 'type' => '301', 'hits' => 97, 'status' => 'paused'],
        ];

        foreach ($redirects as $r) {
            Redirect::firstOrCreate(['from_url' => $r['from_url']], $r);
        }
    }

    protected function seedNotFoundLogs(): void
    {
        $logs = [
            ['url' => '/products/aurora-bag', 'hit_count' => 34],
            ['url' => '/shop/clutch-bags', 'hit_count' => 21],
            ['url' => '/products/milano-tote', 'hit_count' => 18],
            ['url' => '/summer-collection', 'hit_count' => 9],
        ];

        foreach ($logs as $l) {
            NotFoundLog::firstOrCreate(['url' => $l['url']], $l);
        }
    }

    protected function seedNotificationCampaigns(): void
    {
        $campaigns = [
            ['title' => 'Summer Sale Launch', 'channel' => 'email', 'audience' => 'all', 'subject' => 'Summer Sale is here', 'message_body' => 'Enjoy up to 30% off select styles this week only.', 'status' => 'sent', 'sent_count' => 12480, 'sent_at' => now()->subDays(4)],
            ['title' => 'VIP Early Access', 'channel' => 'push', 'audience' => 'vip', 'subject' => null, 'message_body' => 'VIP early access to the Milano Collection starts now.', 'status' => 'sent', 'sent_count' => 890, 'sent_at' => now()->subDays(6)],
            ['title' => 'Cart Reminder — Weekend', 'channel' => 'sms', 'audience' => 'cart', 'subject' => null, 'message_body' => 'Rinmora: Items are still in your cart! Complete your order today and get free shipping.', 'status' => 'sent', 'sent_count' => 1204, 'sent_at' => now()->subDays(8)],
            ['title' => 'New Arrivals: Milano Collection', 'channel' => 'email', 'audience' => 'recent', 'subject' => 'New Arrivals: The Milano Collection has landed', 'message_body' => "Hi there — the Milano Collection is finally here. Crafted from full-grain Italian leather, each piece is limited to 200 units worldwide.", 'status' => 'scheduled', 'sent_count' => 0, 'scheduled_at' => now()->addDays(3)],
            ['title' => 'Back to School Teaser', 'channel' => 'push', 'audience' => 'custom', 'subject' => null, 'message_body' => 'Back to School collection teaser — coming soon.', 'status' => 'draft', 'sent_count' => 0],
        ];

        foreach ($campaigns as $c) {
            NotificationCampaign::firstOrCreate(['title' => $c['title']], $c);
        }
    }

    protected function seedEmailLogs(): void
    {
        $logs = [
            ['recipient_name' => 'Sana Khan', 'recipient_email' => 'sana.khan@gmail.com', 'subject' => 'Order Confirmation #RIN-20591', 'status' => 'opened', 'opened_count' => 3],
            ['recipient_name' => 'Amina R.', 'recipient_email' => 'amina.r@gmail.com', 'subject' => 'Order Confirmation #RIN-20588', 'status' => 'delivered', 'opened_count' => 0],
            ['recipient_name' => 'Zoya Ahmed', 'recipient_email' => 'zoya.ahmed@gmail.com', 'subject' => 'Your refund has been processed', 'status' => 'opened', 'opened_count' => 1],
            ['recipient_name' => 'Bilal Hassan', 'recipient_email' => 'bilal.hassan@gmail.com', 'subject' => 'Summer Sale is here', 'status' => 'bounced', 'opened_count' => 0],
            ['recipient_name' => 'Fatima N.', 'recipient_email' => 'fatima.n@gmail.com', 'subject' => 'Summer Sale is here', 'status' => 'failed', 'opened_count' => 0],
            ['recipient_name' => 'Hassan Ali', 'recipient_email' => 'hassan.ali@gmail.com', 'subject' => 'New Arrivals: The Milano Collection has landed', 'status' => 'queued', 'opened_count' => 0],
        ];

        foreach ($logs as $l) {
            EmailLog::firstOrCreate(['recipient_email' => $l['recipient_email'], 'subject' => $l['subject']], $l);
        }
    }
}

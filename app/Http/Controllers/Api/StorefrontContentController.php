<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageNotification;
use App\Models\Cms\Faq;
use App\Models\Cms\SeoMeta;
use App\Models\Currency;
use App\Models\Page;
use App\Models\Setting;
use App\Models\System\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class StorefrontContentController extends Controller
{
    public function page(string $slug)
    {
        $page = Page::published()->where('slug', $slug)->first();

        if (! $page) {
            return response()->json(['message' => 'Page not found.'], 404);
        }

        return response()->json([
            'data' => [
                'name' => $page->name,
                'slug' => $page->slug,
                'content' => $page->content,
                'meta_title' => $page->meta_title,
                'meta_description' => $page->meta_description,
                'meta_keywords' => $page->meta_keywords,
                'updated_at' => $page->updated_at?->toIso8601String(),
            ],
        ]);
    }

    public function faqs(Request $request)
    {
        $query = Faq::visible()->ordered();

        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        $faqs = $query->get(['id', 'category', 'question', 'answer']);

        return response()->json([
            'data' => $faqs,
            'categories' => Faq::CATEGORIES,
        ]);
    }

    public function contact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $message = $validated['message'];
        if (! empty($validated['phone'])) {
            $message .= "\n\nPhone: {$validated['phone']}";
        }

        $contactMessage = ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $message,
        ]);

        try {
            Mail::to(config('mail.admin_address', 'contact@rinmora.com'))
                ->send(new ContactMessageNotification($contactMessage));
        } catch (\Throwable $e) {
            Log::warning('Contact notification email failed', ['error' => $e->getMessage()]);
        }

        return response()->json(['message' => 'Your message has been sent. We\'ll get back to you within 24 hours.']);
    }

    public function siteSettings()
    {
        $branding = Setting::getByGroup('store_branding');
        $social = Setting::getByGroup('social_media');
        $storeInfo = Setting::getByGroup('store_info');
        $theme = Setting::getByGroup('theme');
        $themePrimary = $theme['primary_color'] ?? '#CFBAA5';

        $assetUrl = fn (?string $path) => $path ? Storage::disk('public_uploads')->url($path) : null;

        $platforms = ['facebook', 'instagram', 'tiktok', 'pinterest', 'youtube', 'linkedin', 'twitter', 'whatsapp'];
        $socialLinks = collect($platforms)
            ->map(fn ($platform) => [
                'platform' => $platform,
                'url' => $social["{$platform}_url"] ?? null,
            ])
            ->filter(fn ($link) => ($social["{$link['platform']}_enabled"] ?? '0') === '1' && ! empty($link['url']))
            ->values();

        return response()->json([
            'data' => [
                'branding' => [
                    'logo_url' => $assetUrl($branding['logo_path'] ?? null),
                    'dark_logo_url' => $assetUrl($branding['dark_logo_path'] ?? null),
                    'mobile_logo_url' => $assetUrl($branding['mobile_logo_path'] ?? null),
                    'favicon_url' => $assetUrl($branding['favicon_path'] ?? null),
                ],
                'social' => $socialLinks,
                'currency' => (function () {
                    $currency = Currency::active();

                    if (! $currency) {
                        return ['code' => 'USD', 'symbol' => '$', 'symbol_position' => 'before', 'decimal_places' => 2, 'exchange_rate' => 1];
                    }

                    return [
                        'code' => $currency->code,
                        'symbol' => $currency->symbol,
                        'symbol_position' => $currency->symbol_position,
                        'decimal_places' => $currency->decimal_places,
                        'exchange_rate' => (float) $currency->exchange_rate,
                    ];
                })(),
                'theme' => [
                    'primary_color' => $themePrimary,
                    'primary_dark_color' => darkenHex($themePrimary),
                    'ink_color' => $theme['secondary_color'] ?? '#000000',
                ],
                'store' => [
                    'name' => $storeInfo['biz_name'] ?? null,
                    'phone' => $storeInfo['biz_phone'] ?? null,
                    'email' => $storeInfo['biz_email'] ?? null,
                    'support_phone' => $storeInfo['support_phone'] ?? null,
                    'support_email' => $storeInfo['support_email'] ?? null,
                    'address' => $storeInfo['biz_address'] ?? null,
                    'description' => $storeInfo['store_desc'] ?? null,
                    'hours' => json_decode($storeInfo['business_hours'] ?? '[]', true) ?: null,
                ],
            ],
        ]);
    }

    public function seo(Request $request)
    {
        $path = $request->input('path', '/');

        $seo = SeoMeta::where('page_url', $path)->first();

        if (! $seo) {
            return response()->json(['data' => null]);
        }

        return response()->json([
            'data' => [
                'meta_title' => $seo->meta_title,
                'meta_description' => $seo->meta_description,
                'canonical_url' => $seo->canonical_url,
                'og_image_url' => $seo->og_image_url,
                'twitter_card_type' => $seo->twitter_card_type,
                'schema_type' => $seo->schema_type,
                'schema_json' => $seo->schema_json,
            ],
        ]);
    }
}

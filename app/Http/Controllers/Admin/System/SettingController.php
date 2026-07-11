<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Setting;
use App\Models\System\TaxRule;
use App\Services\Catalog\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SettingController extends Controller
{
    protected const PLATFORMS = ['facebook', 'instagram', 'tiktok', 'pinterest', 'youtube', 'linkedin', 'twitter', 'whatsapp'];

    public function __construct(protected ImageUploadService $imageUploadService)
    {
    }

    public function index(Request $request)
    {
        $tab = $request->get('tab', 'general');

        $general = Setting::getByGroup('general');
        $storeInfo = Setting::getByGroup('store_info');
        $businessHours = json_decode($storeInfo['business_hours'] ?? '[]', true) ?: [];
        $branding = Setting::getByGroup('store_branding');
        $theme = Setting::getByGroup('theme');
        $smtp = Setting::getByGroup('smtp');
        $sms = Setting::getByGroup('sms');
        $socialMedia = Setting::getByGroup('social_media');
        $seo = Setting::getByGroup('seo');
        $currencies = Currency::ordered()->get();
        $language = Setting::getByGroup('language');
        $enabledLanguages = json_decode($language['enabled_languages'] ?? '[]', true) ?: [];
        $timezone = Setting::getByGroup('timezone');
        $taxRules = TaxRule::orderBy('id')->get();
        $environment = Setting::getByGroup('environment');

        return view('admin.system.settings.index', compact(
            'tab', 'general', 'storeInfo', 'branding', 'theme', 'smtp', 'sms',
            'socialMedia', 'seo', 'currencies', 'language', 'enabledLanguages', 'timezone', 'taxRules',
            'businessHours', 'environment'
        ));
    }

    public function updateGeneral(Request $request)
    {
        $data = $request->validate([
            'store_name' => 'required|string|max:255',
            'default_country' => 'required|string|max:255',
        ]);
        $data['store_status'] = $request->boolean('store_status') ? '1' : '0';
        $data['maintenance_mode'] = $request->boolean('maintenance_mode') ? '1' : '0';

        foreach ($data as $key => $value) {
            Setting::setValue($key, $value, 'general');
        }

        return redirect()->route('admin.system.settings.index', ['tab' => 'general'])->with('success', 'General settings saved.');
    }

    public function updateStoreInfo(Request $request)
    {
        $data = $request->validate([
            'biz_name' => 'required|string|max:255',
            'biz_phone' => 'nullable|string|max:255',
            'biz_address' => 'nullable|string|max:500',
            'biz_email' => 'nullable|email|max:255',
            'support_phone' => 'nullable|string|max:255',
            'support_email' => 'nullable|email|max:255',
            'store_desc' => 'nullable|string|max:2000',
        ]);

        $days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        $hours = [];
        foreach ($days as $day) {
            $hours[$day] = [
                'open' => $request->boolean("hours_{$day}_open"),
                'from' => $request->input("hours_{$day}_from", '10:00 AM'),
                'to' => $request->input("hours_{$day}_to", '8:00 PM'),
            ];
        }
        $data['business_hours'] = json_encode($hours);

        foreach ($data as $key => $value) {
            Setting::setValue($key, $value, 'store_info');
        }

        return redirect()->route('admin.system.settings.index', ['tab' => 'store-info'])->with('success', 'Store information saved.');
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|max:2048',
            'dark_logo' => 'nullable|image|max:2048',
            'mobile_logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:1024',
        ]);

        $fields = ['logo' => 'logo_path', 'dark_logo' => 'dark_logo_path', 'mobile_logo' => 'mobile_logo_path', 'favicon' => 'favicon_path'];
        foreach ($fields as $input => $key) {
            if ($request->hasFile($input)) {
                $stored = $this->imageUploadService->store($request->file($input), 'settings/branding');
                Setting::setValue($key, $stored['path'], 'store_branding');
            }
        }

        return redirect()->route('admin.system.settings.index', ['tab' => 'logo-favicon'])->with('success', 'Assets uploaded.');
    }

    public function updateTheme(Request $request)
    {
        $data = $request->validate([
            'primary_color' => 'required|string|max:20',
            'secondary_color' => 'required|string|max:20',
            'accent_color' => 'required|string|max:20',
            'background_color' => 'required|string|max:20',
        ]);

        foreach ($data as $key => $value) {
            Setting::setValue($key, $value, 'theme');
        }

        return redirect()->route('admin.system.settings.index', ['tab' => 'theme-colors'])->with('success', 'Theme colors saved.');
    }

    public function updateEmail(Request $request)
    {
        $data = $request->validate([
            'resend_api_key' => 'nullable|string|max:255|starts_with:re_',
            'sender_name' => 'nullable|string|max:255',
            'sender_email' => 'nullable|email|max:255',
        ]);

        foreach ($data as $key => $value) {
            if ($value !== null) {
                Setting::setValue($key, $value, 'smtp');
            }
        }

        return redirect()->route('admin.system.settings.index', ['tab' => 'email'])->with('success', 'Email settings saved.');
    }

    public function sendTestEmail(Request $request)
    {
        $request->validate(['test_email' => 'required|email']);

        try {
            Mail::raw('This is a test email from Rinmora Admin settings. If you received this, your mail configuration is working.', function ($message) use ($request) {
                $message->to($request->test_email)->subject('Rinmora — Test Email');
            });

            Setting::setValue('last_tested_at', now()->toDateTimeString(), 'smtp');

            return back()->with('success', 'Test email sent via Resend to '.$request->test_email.' — check the inbox (and spam folder).');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to send test email: '.$e->getMessage());
        }
    }

    public function updateSms(Request $request)
    {
        $data = $request->validate([
            'sms_provider' => 'required|string|max:255',
            'sms_sender' => 'nullable|string|max:255',
            'sms_api_key' => 'nullable|string|max:255',
        ]);
        $data['sms_enabled'] = $request->boolean('sms_enabled') ? '1' : '0';

        foreach ($data as $key => $value) {
            Setting::setValue($key, $value, 'sms');
        }

        return redirect()->route('admin.system.settings.index', ['tab' => 'sms'])->with('success', 'SMS settings saved.');
    }

    public function sendTestSms(Request $request)
    {
        return back()->with('success', 'Test SMS simulated (demo only — no SMS provider is integrated).');
    }

    public function updateSocial(Request $request)
    {
        foreach (self::PLATFORMS as $platform) {
            Setting::setValue("{$platform}_url", $request->input("{$platform}_url", ''), 'social_media');
            Setting::setValue("{$platform}_enabled", $request->boolean("{$platform}_enabled") ? '1' : '0', 'social_media');
        }

        return redirect()->route('admin.system.settings.index', ['tab' => 'social'])->with('success', 'Social media links saved.');
    }

    public function updateSeo(Request $request)
    {
        $data = $request->validate([
            'store_meta_title' => 'nullable|string|max:255',
            'store_meta_description' => 'nullable|string|max:500',
            'store_meta_keywords' => 'nullable|string|max:255',
            'store_canonical_url' => 'nullable|string|max:255',
            'store_og_image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('store_og_image')) {
            $stored = $this->imageUploadService->store($request->file('store_og_image'), 'settings/seo');
            Setting::setValue('store_og_image', $stored['path'], 'seo');
        }
        unset($data['store_og_image']);

        foreach ($data as $key => $value) {
            Setting::setValue($key, $value, 'seo');
        }

        return redirect()->route('admin.system.settings.index', ['tab' => 'seo'])->with('success', 'SEO defaults saved.');
    }

    public function updateLanguage(Request $request)
    {
        $data = $request->validate([
            'default_language' => 'required|string|max:10',
        ]);
        $data['rtl_layout'] = $request->boolean('rtl_layout') ? '1' : '0';
        $data['enabled_languages'] = json_encode($request->input('enabled_languages', []));

        foreach ($data as $key => $value) {
            Setting::setValue($key, $value, 'language');
        }

        return redirect()->route('admin.system.settings.index', ['tab' => 'language'])->with('success', 'Language settings saved.');
    }

    public function updateEnvironment(Request $request)
    {
        $data = $request->validate([
            'mode' => 'required|in:development,production',
            'dev_admin_url' => 'nullable|url|max:255',
            'dev_frontend_url' => 'nullable|url|max:255',
            'dev_api_url' => 'nullable|url|max:255',
            'prod_admin_url' => 'nullable|url|max:255',
            'prod_frontend_url' => 'nullable|url|max:255',
            'prod_api_url' => 'nullable|url|max:255',
        ]);

        foreach ($data as $key => $value) {
            Setting::setValue($key, (string) $value, 'environment');
        }

        return redirect()->route('admin.system.settings.index', ['tab' => 'environment'])->with('success', 'Environment settings saved.');
    }

    public function updateTimezone(Request $request)
    {
        $data = $request->validate([
            'timezone' => 'required|string|max:255',
            'date_format' => 'required|string|max:20',
            'time_format' => 'required|in:12,24',
        ]);

        foreach ($data as $key => $value) {
            Setting::setValue($key, $value, 'timezone');
        }

        return redirect()->route('admin.system.settings.index', ['tab' => 'timezone'])->with('success', 'Timezone settings saved.');
    }

    public function storeTaxRule(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'applies_to' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0|max:100',
        ]);
        $data['is_active'] = $request->boolean('is_active');

        TaxRule::create($data);

        return redirect()->route('admin.system.settings.index', ['tab' => 'taxes'])->with('success', 'Tax rule added.');
    }

    public function updateTaxRule(Request $request, TaxRule $taxRule)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'applies_to' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0|max:100',
        ]);
        $data['is_active'] = $request->boolean('is_active');

        $taxRule->update($data);

        return redirect()->route('admin.system.settings.index', ['tab' => 'taxes'])->with('success', 'Tax rule updated.');
    }

    public function destroyTaxRule(TaxRule $taxRule)
    {
        $taxRule->delete();

        return redirect()->route('admin.system.settings.index', ['tab' => 'taxes'])->with('success', 'Tax rule deleted.');
    }
}

<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class EmailServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    /**
     * Admin-configured values (Settings > Email Settings, group "smtp") take
     * priority over .env so the Resend key/sender identity can be rotated
     * from the admin panel without a redeploy. Wrapped in try/catch because
     * this runs on every request before routing — a transient DB hiccup here
     * must not take down the whole app (this previously crash-looped every
     * request when the DB connection wasn't ready yet).
     */
    public function boot(): void
    {
        try {
            if (! Schema::hasTable('settings')) {
                return;
            }

            $smtp = Setting::getByGroup('smtp');

            if (! empty($smtp['resend_api_key'])) {
                config(['services.resend.key' => $smtp['resend_api_key']]);
            }

            if (! empty($smtp['sender_email'])) {
                config(['mail.from.address' => $smtp['sender_email']]);
            }

            if (! empty($smtp['sender_name'])) {
                config(['mail.from.name' => $smtp['sender_name']]);
            }
        } catch (\Throwable $e) {
            Log::warning('EmailServiceProvider: could not load dynamic mail settings', ['error' => $e->getMessage()]);
        }
    }
}
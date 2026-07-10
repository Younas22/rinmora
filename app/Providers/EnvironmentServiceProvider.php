<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class EnvironmentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    /**
     * Admin-configured Development/Production URLs (Settings > Environment & URLs)
     * override .env at runtime, same pattern as EmailServiceProvider. Only
     * "Frontend URL" has a real consumer in this codebase (password-reset and
     * welcome emails read services.frontend.url) — Admin Panel URL / API URL
     * are stored for reference only, to keep the Next.js frontend's own
     * .env.development/.env.production in sync, since nothing in this Laravel
     * app reads them back.
     */
    public function boot(): void
    {
        try {
            if (! Schema::hasTable('settings')) {
                return;
            }

            $env = Setting::getByGroup('environment');
            $mode = $env['mode'] ?? 'development';

            $frontendUrl = $mode === 'production'
                ? ($env['prod_frontend_url'] ?? null)
                : ($env['dev_frontend_url'] ?? null);

            if (! empty($frontendUrl)) {
                config(['services.frontend.url' => $frontendUrl]);
            }
        } catch (\Throwable $e) {
            Log::warning('EnvironmentServiceProvider: could not load dynamic environment settings', ['error' => $e->getMessage()]);
        }
    }
}

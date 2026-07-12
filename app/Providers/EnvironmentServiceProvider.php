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
     * The admin's Development/Production toggle (Settings > Environment & URLs)
     * is the single source of truth for which URL set is "live" everywhere in
     * this app: whichever mode is selected, every generated URL (app/asset
     * URLs, uploaded-file URLs, and the frontend URL used in emails) uses that
     * mode's configured Admin Panel URL / Frontend URL — not whatever host
     * happened to serve the current request, and not .env's static APP_URL.
     * Flip the toggle to development and every URL becomes the dev one;
     * flip it to production and every URL becomes the live one.
     */
    public function boot(): void
    {
        try {
            if (! Schema::hasTable('settings')) {
                return;
            }

            $env = Setting::getByGroup('environment');
            $mode = $env['mode'] ?? 'development';
            $isProd = $mode === 'production';

            $adminUrl = $isProd ? ($env['prod_admin_url'] ?? null) : ($env['dev_admin_url'] ?? null);
            $frontendUrl = $isProd ? ($env['prod_frontend_url'] ?? null) : ($env['dev_frontend_url'] ?? null);

            $this->overrideAssetUrl($adminUrl);

            if (! empty($frontendUrl)) {
                config(['services.frontend.url' => $frontendUrl]);
            }
        } catch (\Throwable $e) {
            Log::warning('EnvironmentServiceProvider: could not load dynamic environment settings', ['error' => $e->getMessage()]);
        }
    }

    /**
     * `APP_URL` in .env is a single static value, so uploaded-file URLs (logo,
     * favicon, product images, ...) silently break the moment this same
     * codebase is reached through a different domain than whatever .env
     * happened to have baked in. Fixed by rebuilding `app.url` and the
     * `public_uploads` disk's URL from the admin's configured Admin Panel URL
     * for the currently-selected mode. Falls back to the CURRENT request's own
     * host (skipped in console — no request there) only if that mode's Admin
     * Panel URL setting hasn't been filled in yet, so the app still works
     * before an admin has configured these settings at all.
     */
    protected function overrideAssetUrl(?string $configuredUrl): void
    {
        try {
            $baseUrl = $configuredUrl ?: (! $this->app->runningInConsole() ? request()->root() : null);

            if (empty($baseUrl)) {
                return;
            }

            $baseUrl = rtrim($baseUrl, '/');

            config([
                'app.url' => $baseUrl,
                'filesystems.disks.public_uploads.url' => $baseUrl.'/public/uploads',
            ]);
        } catch (\Throwable $e) {
            Log::warning('EnvironmentServiceProvider: could not override asset URL', ['error' => $e->getMessage()]);
        }
    }
}

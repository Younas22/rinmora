<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Cms\HomepageController;
use App\Http\Controllers\Admin\Cms\MediaController;
use App\Http\Controllers\Admin\Cms\SeoController;
use App\Http\Controllers\Admin\Cms\NotificationController;

// Rinmora e-commerce admin (Marketing/CMS module). Same conventions as
// routes/admin_catalog.php, routes/admin_sales.php, routes/admin_customers.php.
//
// IMPORTANT: Str::singular('media') resolves to 'medium' — the implicit
// route-model-binding param for media/{medium} must be named $medium in
// controller method signatures, not $media, or binding silently fails.
Route::middleware(['auth', 'admin'])->group(function () {
    Route::name('admin.cms.')->group(function () {
        Route::get('homepage-sections', [HomepageController::class, 'index'])->name('homepage-sections.index');
        Route::post('homepage-sections', [HomepageController::class, 'store'])->name('homepage-sections.store');
        Route::patch('homepage-sections/{homepage_section}', [HomepageController::class, 'update'])->name('homepage-sections.update');
        Route::delete('homepage-sections/{homepage_section}', [HomepageController::class, 'destroy'])->name('homepage-sections.destroy');
        Route::post('homepage-sections/reorder', [HomepageController::class, 'reorder'])->name('homepage-sections.reorder');

        Route::get('media', [MediaController::class, 'index'])->name('media.index');
        Route::post('media', [MediaController::class, 'store'])->name('media.store');
        Route::patch('media/{medium}', [MediaController::class, 'update'])->name('media.update');
        Route::delete('media/{medium}', [MediaController::class, 'destroy'])->name('media.destroy');
        Route::post('media/bulk-delete', [MediaController::class, 'bulkDestroy'])->name('media.bulk-destroy');
        Route::post('media/bulk-move', [MediaController::class, 'bulkMove'])->name('media.bulk-move');

        Route::get('seo', [SeoController::class, 'index'])->name('seo.index');
        Route::put('seo/meta/{seoMeta}', [SeoController::class, 'updateMeta'])->name('seo.meta.update');
        Route::put('seo/robots', [SeoController::class, 'updateRobots'])->name('seo.robots.update');
        Route::post('seo/sitemap/regenerate', [SeoController::class, 'regenerateSitemap'])->name('seo.sitemap.regenerate');
        Route::post('seo/redirects', [SeoController::class, 'storeRedirect'])->name('seo.redirects.store');
        Route::patch('seo/redirects/{redirect}', [SeoController::class, 'updateRedirect'])->name('seo.redirects.update');
        Route::delete('seo/redirects/{redirect}', [SeoController::class, 'destroyRedirect'])->name('seo.redirects.destroy');
        Route::post('seo/not-found/{notFoundLog}/create-redirect', [SeoController::class, 'createRedirectFromNotFound'])->name('seo.not-found.create-redirect');
        Route::put('seo/schema/{seoMeta}', [SeoController::class, 'updateSchema'])->name('seo.schema.update');

        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('notifications/campaigns', [NotificationController::class, 'storeCampaign'])->name('notifications.campaigns.store');
        Route::post('notifications/campaigns/{campaign}/send', [NotificationController::class, 'sendCampaign'])->name('notifications.campaigns.send');
    });
});

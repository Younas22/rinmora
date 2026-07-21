<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\System\UserController;
use App\Http\Controllers\Admin\System\RoleController;
use App\Http\Controllers\Admin\System\ActivityController;
use App\Http\Controllers\Admin\System\ReportController;
use App\Http\Controllers\Admin\System\SupportController;
use App\Http\Controllers\Admin\System\ProfileController;
use App\Http\Controllers\Admin\System\SettingController;
use App\Http\Controllers\Admin\System\CurrencyController;

// Rinmora e-commerce admin (Admin/System module). Same conventions as
// routes/admin_catalog.php, routes/admin_sales.php, routes/admin_customers.php,
// routes/admin_cms.php.
//
// IMPORTANT: this route namespace is admin.system.* — the legacy SkyBooking
// settings routes (admin.settings.*) and legacy newsletter routes
// (admin.content.newsletter.*) already exist elsewhere and are untouched.
Route::middleware(['auth', 'admin'])->group(function () {
    Route::name('admin.system.')->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::patch('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
        Route::patch('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
        Route::put('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');

        Route::get('activity', [ActivityController::class, 'index'])->name('activity.index');
        Route::post('activity/error-logs/{errorLog}/resolve', [ActivityController::class, 'resolveError'])->name('activity.error-logs.resolve');

        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/sales/export', [ReportController::class, 'exportSalesCsv'])->name('reports.sales.export');

        Route::get('support', [SupportController::class, 'index'])->name('support.index');
        Route::post('support/messages/{message}/reply', [SupportController::class, 'replyMessage'])->name('support.messages.reply');
        Route::post('support/messages/{message}/toggle-read', [SupportController::class, 'toggleReadMessage'])->name('support.messages.toggle-read');
        Route::post('support/messages/{message}/archive', [SupportController::class, 'archiveMessage'])->name('support.messages.archive');
        Route::delete('support/messages/{message}', [SupportController::class, 'destroyMessage'])->name('support.messages.destroy');
        Route::post('support/messages/bulk-delete', [SupportController::class, 'bulkDestroyMessages'])->name('support.messages.bulk-destroy');
        Route::post('support/tickets/{ticket}/reply', [SupportController::class, 'replyTicket'])->name('support.tickets.reply');
        Route::delete('support/tickets/{ticket}', [SupportController::class, 'destroyTicket'])->name('support.tickets.destroy');
        Route::post('support/tickets/bulk-delete', [SupportController::class, 'bulkDestroyTickets'])->name('support.tickets.bulk-destroy');
        Route::delete('support/newsletter/{subscriber}', [SupportController::class, 'destroySubscriber'])->name('support.newsletter.destroy');
        Route::post('support/newsletter/bulk-delete', [SupportController::class, 'bulkDestroySubscribers'])->name('support.newsletter.bulk-destroy');

        Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::patch('profile/preferences', [ProfileController::class, 'updatePreferences'])->name('profile.preferences');
        Route::post('profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings/general', [SettingController::class, 'updateGeneral'])->name('settings.general');
        Route::put('settings/store-info', [SettingController::class, 'updateStoreInfo'])->name('settings.store-info');
        Route::put('settings/logo', [SettingController::class, 'updateLogo'])->name('settings.logo');
        Route::put('settings/theme', [SettingController::class, 'updateTheme'])->name('settings.theme');
        Route::put('settings/email', [SettingController::class, 'updateEmail'])->name('settings.email');
        Route::post('settings/email/send-test', [SettingController::class, 'sendTestEmail'])->name('settings.email.send-test');
        Route::put('settings/sms', [SettingController::class, 'updateSms'])->name('settings.sms');
        Route::post('settings/sms/send-test', [SettingController::class, 'sendTestSms'])->name('settings.sms.send-test');
        Route::put('settings/social', [SettingController::class, 'updateSocial'])->name('settings.social');
        Route::put('settings/seo', [SettingController::class, 'updateSeo'])->name('settings.seo');
        Route::post('settings/currencies', [CurrencyController::class, 'store'])->name('settings.currencies.store');
        Route::put('settings/currencies/{currency}', [CurrencyController::class, 'update'])->name('settings.currencies.update');
        Route::delete('settings/currencies/{currency}', [CurrencyController::class, 'destroy'])->name('settings.currencies.destroy');
        Route::post('settings/currencies/{currency}/activate', [CurrencyController::class, 'activate'])->name('settings.currencies.activate');
        Route::put('settings/language', [SettingController::class, 'updateLanguage'])->name('settings.language');
        Route::put('settings/timezone', [SettingController::class, 'updateTimezone'])->name('settings.timezone');
        Route::put('settings/environment', [SettingController::class, 'updateEnvironment'])->name('settings.environment');
        Route::post('settings/tax-rules', [SettingController::class, 'storeTaxRule'])->name('settings.tax-rules.store');
        Route::patch('settings/tax-rules/{taxRule}', [SettingController::class, 'updateTaxRule'])->name('settings.tax-rules.update');
        Route::delete('settings/tax-rules/{taxRule}', [SettingController::class, 'destroyTaxRule'])->name('settings.tax-rules.destroy');
    });
});

<?php
// routes/admin.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\AuthController;


// Protected Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard now served from routes/admin_catalog.php (Admin\Catalog\DashboardController)
    // Customers now served from routes/admin_customers.php (Admin\Customers\CustomerController)

    // Content Management
    Route::prefix('content')->name('admin.content.')->group(function () {
        // Blog Management
        Route::prefix('blog')->name('blog.')->group(function () {
            Route::get('/', [BlogController::class, 'index'])->name('index');
            Route::get('/create', [BlogController::class, 'create'])->name('create');
            Route::post('/', [BlogController::class, 'store'])->name('store');
            Route::get('/{post}', [BlogController::class, 'show'])->name('show');
            Route::get('/{post}/edit', [BlogController::class, 'edit'])->name('edit');
            Route::patch('/{post}', [BlogController::class, 'update'])->name('update');
            Route::delete('/{post}', [BlogController::class, 'destroy'])->name('destroy');
            Route::post('/upload-image', [BlogController::class, 'uploadImage'])->name('upload-image');
            // Additional routes for actions
            Route::post('/{post}/publish', [BlogController::class, 'publish'])->name('publish');
            Route::post('/{post}/cancel-schedule', [BlogController::class, 'cancelSchedule'])->name('cancel-schedule');
            Route::post('/{post}/duplicate', [BlogController::class, 'duplicate'])->name('duplicate');



            
        });
  

 
        // Category Management
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [BlogController::class, 'getCategories'])->name('index');
            Route::post('/', [BlogController::class, 'storeCategory'])->name('store');
            Route::get('/{category}', [BlogController::class, 'getCategory'])->name('show');
            Route::put('/{category}', [BlogController::class, 'updateCategory'])->name('update');
            Route::delete('/{category}', [BlogController::class, 'deleteCategory'])->name('destroy');
            Route::post('/{category}/toggle-status', [BlogController::class, 'toggleCategoryStatus'])->name('toggle-status');
            Route::post('/update-order', [BlogController::class, 'updateCategoryOrder'])->name('update-order');
        });

        Route::prefix('newsletter')->name('newsletter.')->group(function () {
            Route::get('/', [NewsletterController::class, 'index'])->name('index');
            Route::get('/subscribers', [NewsletterController::class, 'subscribers'])->name('subscribers');
            Route::get('/subscribers/{id}', [NewsletterController::class, 'showSubscriber']);
            Route::post('/subscribers', [NewsletterController::class, 'storeSubscriber'])->name('store-subscriber');
            Route::patch('/subscribers/{id}', [NewsletterController::class, 'updateSubscriber']);
            Route::delete('/subscribers/{id}', [NewsletterController::class, 'destroySubscriber']);
            Route::post('/subscribers/bulk/{action}', [NewsletterController::class, 'bulkAction']);
            Route::post('/bulk-import', [NewsletterController::class, 'bulkImport'])->name('bulk-import');
            Route::patch('/subscribers/{id}/{action}', [NewsletterController::class, 'changeStatus']);
            Route::post('/send', [NewsletterController::class, 'send'])->name('send');
        });


    });
    

                   // Pages Management Routes
        Route::prefix('pages')->name('admin.pages.')->group(function () {
            Route::get('/', [PageController::class, 'index'])->name('index');
            Route::get('/create', [PageController::class, 'create'])->name('create');
            Route::post('/', [PageController::class, 'store'])->name('store');
            Route::get('/{page}/edit', [PageController::class, 'edit'])->name('edit');
            Route::patch('/{page}', [PageController::class, 'update'])->name('update');
            Route::delete('/{page}', [PageController::class, 'destroy'])->name('destroy');
            Route::get('/{page}', [PageController::class, 'show'])->name('show');
            
            // Additional functionality
            Route::post('/bulk-action', [PageController::class, 'bulkAction'])->name('bulk-action');
            Route::post('/upload-image', [PageController::class, 'uploadImage'])->name('upload-image');
            Route::post('/{page}/duplicate', [PageController::class, 'duplicate'])->name('duplicate');
            Route::post('/update-sort-order', [PageController::class, 'updateSortOrder'])->name('update-sort-order');
        });

                   // Pages Management Routes
        Route::prefix('menus')->name('admin.menus.')->group(function () {
            // Menu Management
            Route::get('/', [MenuController::class, 'index'])->name('index');
            Route::get('/create', [MenuController::class, 'create'])->name('create');
            Route::post('/', [MenuController::class, 'store'])->name('store');
            Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('edit');
            Route::put('/{menu}', [MenuController::class, 'update'])->name('update');
            Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('destroy');
            
            // Additional Menu Routes
            Route::post('/update-sort-order', [MenuController::class, 'updateSortOrder'])->name('update-sort-order');
            Route::post('/bulk-action', [MenuController::class, 'bulkAction'])->name('bulk-action');
            Route::post('/{menu}/toggle-status', [MenuController::class, 'toggleStatus'])->name('toggle-status');
            Route::get('/get-parent-items', [MenuController::class, 'getParentItems'])->name('get-parent-items');
            Route::post('/{menu}/duplicate', [MenuController::class, 'duplicate'])->name('duplicate');
        });

        

    // Settings
    Route::prefix('settings')->name('admin.settings.')->group(function () {
        Route::get('/website', [SettingController::class, 'website'])->name('website');
        Route::post('/website', [SettingController::class, 'updateWebsite'])->name('website.update');
        Route::get('/email', [SettingController::class, 'email'])->name('email');
        Route::post('/email', [SettingController::class, 'updateEmail'])->name('email.update');
        
        // Email settings routes mein add karo
        Route::post('/settings/email/test-connection', [SettingController::class, 'testEmailConnection'])->name('email.test-connection');
        Route::post('/settings/email/send-test', [SettingController::class, 'sendTestEmail'])->name('email.send-test');
    });
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Catalog\DashboardController;
use App\Http\Controllers\Admin\Catalog\CategoryController;
use App\Http\Controllers\Admin\Catalog\BrandController;
use App\Http\Controllers\Admin\Catalog\AttributeController;
use App\Http\Controllers\Admin\Catalog\ProductController;
use App\Http\Controllers\Admin\Catalog\InventoryController;
use App\Http\Controllers\Admin\Catalog\ReviewController;

// Rinmora e-commerce admin (Catalog module). Separate from the legacy
// Bootstrap admin in routes/admin.php — different layout, own controllers.
// Lives directly under /admin (no /store prefix); /admin/dashboard is the
// main admin landing page, reusing the 'admin.dashboard.index' route name
// so login redirects and old sidebar links keep working unchanged.
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');

    Route::name('admin.catalog.')->group(function () {
        Route::resource('categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);

        Route::resource('brands', BrandController::class)->only(['index', 'store', 'update', 'destroy']);

        Route::post('collections', [BrandController::class, 'storeCollection'])->name('collections.store');
        Route::put('collections/{collection}', [BrandController::class, 'updateCollection'])->name('collections.update');
        Route::delete('collections/{collection}', [BrandController::class, 'destroyCollection'])->name('collections.destroy');

        Route::resource('attributes', AttributeController::class)->except(['show', 'create', 'edit']);
        Route::delete('attributes/{attribute}/values/{value}', [AttributeController::class, 'destroyValue'])->name('attributes.values.destroy');

        Route::resource('products', ProductController::class);
        Route::delete('products/{product}/images/{image}', [ProductController::class, 'destroyImage'])->name('products.images.destroy');
        Route::post('products/{product}/images/{image}/cover', [ProductController::class, 'setCoverImage'])->name('products.images.cover');

        Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::post('inventory/{product}/adjust', [InventoryController::class, 'adjust'])->name('inventory.adjust');

        Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::patch('reviews/{review}/status', [ReviewController::class, 'updateStatus'])->name('reviews.status');
        Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    });
});
